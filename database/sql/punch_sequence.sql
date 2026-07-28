SELECT 
    employee_id,
    DATE(CONVERT_TZ(punches.punched_at, 'UTC', 'Europe/Athens')) AS punch_date,
    GROUP_CONCAT(
        CONCAT(UPPER(direction), ' (', DATE_FORMAT(CONVERT_TZ(punches.punched_at, 'UTC', 'Europe/Athens'), '%H:%i'), ')')
        ORDER BY punched_at ASC
        SEPARATOR ' => '
    ) AS punch_sequence,
    compute_working_minutes(employee_id,  DATE(CONVERT_TZ(punches.punched_at, 'UTC', 'Europe/Athens'))) AS working_minutes
FROM 
    punches
GROUP BY 
    employee_id, 
    DATE(punched_at)
HAVING 
    COUNT(*) > 2;





DELIMITER //

CREATE OR REPLACE FUNCTION compute_working_minutes(
    p_employee_id INT,
    p_date DATE
) 
RETURNS INT
DETERMINISTIC
BEGIN
    DECLARE v_count INT;
    DECLARE v_p1 DATETIME;
    DECLARE v_p2 DATETIME;
    DECLARE v_p3 DATETIME;
    DECLARE v_p4 DATETIME;
    DECLARE v_shift_start_time TIME;
    DECLARE v_shift_end_time TIME;
    DECLARE v_shift_start_dt DATETIME;
    DECLARE v_shift_end_dt DATETIME;
    DECLARE v_total_minutes INT DEFAULT 0;
    DECLARE v_diff_to_start INT;
    DECLARE v_diff_to_end INT;

    -- 1. Count the total punches for this employee on this date
    SELECT COUNT(*) INTO v_count
    FROM punches
    WHERE employee_id = p_employee_id AND DATE(punched_at) = p_date;

    -- If no punches exist, return 0 immediately
    IF v_count = 0 THEN
        RETURN 0;
    END IF;

    -- 2. Extract up to 4 punches, plus shift_start and shift_end from the FIRST punch
    WITH NumberedPunches AS (
        SELECT punched_at,
               shift_start,
               shift_end,
               ROW_NUMBER() OVER (ORDER BY punched_at ASC) as rn
        FROM punches
        WHERE employee_id = p_employee_id AND DATE(punched_at) = p_date
    )
    SELECT 
        MAX(CASE WHEN rn = 1 THEN punched_at END),
        MAX(CASE WHEN rn = 2 THEN punched_at END),
        MAX(CASE WHEN rn = 3 THEN punched_at END),
        MAX(CASE WHEN rn = 4 THEN punched_at END),
        MAX(CASE WHEN rn = 1 THEN shift_start END),
        MAX(CASE WHEN rn = 1 THEN shift_end END)
    INTO v_p1, v_p2, v_p3, v_p4, v_shift_start_time, v_shift_end_time
    FROM NumberedPunches;

    -- Combine the target date with the retrieved shift times into DATETIME objects
    SET v_shift_start_dt = TIMESTAMP(p_date, v_shift_start_time);
    SET v_shift_end_dt = TIMESTAMP(p_date, v_shift_end_time);

    -- 5+ Punches: Return a full shift
    IF v_count >= 5 THEN
        RETURN TIMESTAMPDIFF(MINUTE, v_shift_start_dt, v_shift_end_dt);
    END IF;

    -- 3. Apply the logic based on the punch count
    
    -- Case: 1 Punch
    IF v_count = 1 THEN
        SET v_diff_to_start = ABS(TIMESTAMPDIFF(MINUTE, v_p1, v_shift_start_dt));
        SET v_diff_to_end = ABS(TIMESTAMPDIFF(MINUTE, v_p1, v_shift_end_dt));

        IF v_diff_to_start <= v_diff_to_end THEN
            -- Closer to start: treat punch as IN, shift_end as OUT
            SET v_total_minutes = TIMESTAMPDIFF(MINUTE, v_p1, v_shift_end_dt);
        ELSE
            -- Closer to end: treat shift_start as IN, punch as OUT
            SET v_total_minutes = TIMESTAMPDIFF(MINUTE, v_shift_start_dt, v_p1);
        END IF;

    -- Case: 2 Punches
    ELSEIF v_count = 2 THEN
        SET v_total_minutes = TIMESTAMPDIFF(MINUTE, v_p1, v_p2);

    -- Case: 3 Punches
    ELSEIF v_count = 3 THEN
        -- Using GREATEST(0, ...) prevents negative minutes if the 3rd punch is after shift_end
        SET v_total_minutes = TIMESTAMPDIFF(MINUTE, v_p1, v_p2) + 
                              GREATEST(0, TIMESTAMPDIFF(MINUTE, v_p3, v_shift_end_dt));

    -- Case: 4 Punches
    ELSEIF v_count = 4 THEN
        SET v_total_minutes = TIMESTAMPDIFF(MINUTE, v_p1, v_p2) + 
                              TIMESTAMPDIFF(MINUTE, v_p3, v_p4);
    END IF;

    -- Final safety check to ensure we never return negative working minutes
    IF v_total_minutes < 0 THEN 
        SET v_total_minutes = 0; 
    END IF;

    RETURN v_total_minutes;
END //

DELIMITER ;
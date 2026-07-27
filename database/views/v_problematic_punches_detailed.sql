DROP VIEW IF EXISTS problematic_punches_detailed
;

CREATE VIEW problematic_punches_detailed AS
SELECT 
    p.*,
    problems.total_punches,
    problems.total_ins,
    problems.total_outs
FROM punches p
INNER JOIN (
    SELECT 
        employee_id,
        DATE(punched_at) as punch_date,
        COUNT(*) as total_punches,
        SUM(CASE WHEN direction = 'in' THEN 1 ELSE 0 END) as total_ins,
        SUM(CASE WHEN direction = 'out' THEN 1 ELSE 0 END) as total_outs
    FROM punches
    GROUP BY employee_id, DATE(punched_at)
    HAVING SUM(CASE WHEN direction = 'in' THEN 1 ELSE 0 END) != SUM(CASE WHEN direction = 'out' THEN 1 ELSE 0 END) 
        OR COUNT(*) > 2
) problems 
ON p.employee_id = problems.employee_id 
AND DATE(p.punched_at) = problems.punch_date;
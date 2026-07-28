DROP VIEW IF EXISTS v_problematic_panches
;

CREATE VIEW v_problematic_panches AS
(
  SELECT 
    punches.upload_file_id,
    punches.employee_id,
    employees.lastname,
    employees.firstname,
    DATE(punches.punched_at) as punch_date,
    COUNT(*) as total_punches,
    SUM(CASE WHEN direction = 'in' THEN 1 ELSE 0 END) as total_ins,
    SUM(CASE WHEN direction = 'out' THEN 1 ELSE 0 END) as total_outs,
    GROUP_CONCAT(
      CONCAT(UPPER(direction), ' (', DATE_FORMAT(CONVERT_TZ(punches.punched_at, 'UTC', 'Europe/Athens'), '%H:%i'), ')')
      ORDER BY punched_at ASC
      SEPARATOR ' => '
    ) AS punch_sequence
  FROM 
    punches
    INNER JOIN employees ON employees.id = punches.employee_id
  GROUP BY 
    punches.upload_file_id,
    punches.employee_id,
    employees.lastname,
    employees.firstname,
    DATE(punches.punched_at)
  HAVING 
    total_ins != total_outs OR total_punches > 2
)
;
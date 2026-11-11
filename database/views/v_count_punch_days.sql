DROP VIEW IF EXISTS v_count_punch_days
;

CREATE OR REPLACE VIEW v_count_punch_days AS
WITH daily_punches AS (
  SELECT 
    employee_id,
    DATE(punched_at) AS punch_date,
    COUNT(*) AS punches_count
  FROM punches
  GROUP BY 
    employee_id,
    DATE(punched_at)
)
SELECT 
  employee_id AS id,
  employees.am,
  employees.lastname,
  employees.firstname,
  SUM(CASE WHEN punches_count = 1 THEN 1 ELSE 0 END) AS days_with_1_punch,
  SUM(CASE WHEN punches_count = 2 THEN 1 ELSE 0 END) AS days_with_2_punches,
  SUM(CASE WHEN punches_count = 3 THEN 1 ELSE 0 END) AS days_with_3_punches,
  SUM(CASE WHEN punches_count = 4 THEN 1 ELSE 0 END) AS days_with_4_punches,
  SUM(CASE WHEN punches_count > 4 THEN 1 ELSE 0 END) AS days_with_over_4_punches,
  COUNT(*) AS total_worked_days
FROM 
  daily_punches
  LEFT OUTER JOIN employees ON daily_punches.employee_id = employees.id
GROUP BY 
  employee_id,
  employees.am,
  employees.lastname,
  employees.firstname
;
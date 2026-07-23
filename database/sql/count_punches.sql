-- Μετράει τα χτυπήματα ανά ημέρα για έναν εργαζόμενο για in και out

SELECT 
  employee_id,
  lastname,
  firstname,
  CAST(punched_at AS DATE) AS punch_date,
  SUM(CASE WHEN direction = 'in' THEN 1 ELSE 0 END) AS in_count,
  SUM(CASE WHEN direction = 'out' THEN 1 ELSE 0 END) AS out_count
FROM 
  punches
GROUP BY 
  employee_id,
  lastname,
  firstname,
  CAST(punched_at AS DATE)
HAVING
  SUM(CASE WHEN direction = 'in' THEN 1 ELSE 0 END) > 1 OR
  SUM(CASE WHEN direction = 'out' THEN 1 ELSE 0 END) > 1
ORDER BY 
  employee_id, 
  punch_date
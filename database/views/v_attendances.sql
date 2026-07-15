-- Παρουσιολόγιο
-- Ημερίσια χτυπήματα ανά εργαζόμενο

DROP VIEW IF EXISTS v_attendances
;

CREATE VIEW v_attendances AS
(
  SELECT
    attendances.id AS id,
    attendances.employee_id AS employee_id,
    employees.lastname AS lastname,
    employees.firstname AS firstname,
    attendances.punch_date AS punch_date,
    attendances.shift_start AS shift_start,
    attendances.shift_end AS shift_end,
    attendances.shift_string AS shift_string,
    attendances.punch_in AS punch_in,
    attendances.punch_out AS punch_out,
    attendances.punch_year AS punch_year,
    attendances.punch_month AS punch_month,
    month_names.name AS punch_month_name,
    attendances.punch_day AS punch_day,
    attendances.shift_minutes AS shift_minutes,
    attendances.worked_minutes AS worked_minutes,
    attendances.work_balance_minutes AS work_balance_minutes,
    attendances.overtime_minutes AS overtime_minutes,
    attendances.created_at AS created_at,
    attendances.updated_at AS updated_at
  FROM
    attendances
    INNER JOIN employees ON employees.id = attendances.employee_id
    INNER JOIN month_names ON month_names.id = attendances.punch_month
)
;
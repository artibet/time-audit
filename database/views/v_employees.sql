DROP VIEW IF EXISTS v_employees
;

CREATE VIEW v_employees AS
(
  SELECT
    id,
    lastname,
    firstname,
    am,
    card_no,
    shift_start,
    shift_end,
    last_in,
    last_out,
    created_at,
    updated_at
  FROM
    employees
)
;
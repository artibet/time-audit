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
    last_in,
    last_out,
    created_at,
    updated_at
  FROM
    employees
)
;
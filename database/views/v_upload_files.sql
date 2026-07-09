DROP VIEW IF EXISTS v_upload_files
;

CREATE VIEW v_upload_files AS
(
  SELECT
    upload_files.id id,
    upload_files.descr descr,
    upload_files.starts_at starts_at,
    upload_files.ends_at ends_at,
    upload_files.file_size file_size,
    upload_files.employees_count employees_count,
    upload_files.created_at created_at,
    upload_files.updated_at updated_at
  FROM
    upload_files
)
;
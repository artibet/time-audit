DROP VIEW IF EXISTS v_users
;

CREATE VIEW v_users AS
(
  SELECT
    id,
    email,
    name,
    is_active,
    CASE
      WHEN is_active = 1 THEN 'Ενεργός'
      ELSE 'Ανενεργός'
    END AS is_active_label,
    CASE 
      WHEN EXISTS (SELECT 1 FROM model_has_roles JOIN roles ON roles.id = model_has_roles.role_id 
                  WHERE model_has_roles.model_id = users.id AND roles.name = 'superadmin') 
      THEN 'ΝΑΙ' ELSE 'ΟΧΙ' 
    END AS is_superadmin_label,

    CASE 
      WHEN EXISTS (SELECT 1 FROM model_has_roles JOIN roles ON roles.id = model_has_roles.role_id 
                  WHERE model_has_roles.model_id = users.id AND roles.name = 'admin') 
      THEN 'ΝΑΙ' ELSE 'ΟΧΙ' 
    END AS is_admin_label,

    CASE 
      WHEN EXISTS (SELECT 1 FROM model_has_roles JOIN roles ON roles.id = model_has_roles.role_id 
                  WHERE model_has_roles.model_id = users.id AND roles.name = 'editor') 
      THEN 'ΝΑΙ' ELSE 'ΟΧΙ' 
    END AS is_editor_label,
  
    created_at,
    updated_at
  FROM
    users
)
;
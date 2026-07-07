<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    DB::statement("DROP VIEW IF EXISTS v_users");

    DB::statement("
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
    ");
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    DB::statement("DROP VIEW IF EXISTS v_users");
  }
};

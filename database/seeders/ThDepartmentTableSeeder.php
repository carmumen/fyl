<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThDepartmentTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('th_department')->delete();

        DB::table('th_department')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Financiero',
                'description' => 'Es responsable de la gestión financiera de la empresa. Esto incluye la contabilidad, la elaboración de informes financieros, la planificación y el análisis financiero, la gestión de tesorería, la gestión de riesgos y el cumplimiento de regulaciones fiscal',
                'status' => 'ACTIVE',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Marketing',
                'description' => 'Se encarga de promover los productos o servicios de la empresa y de construir la marca. Esto incluye la investigación de mercado, la publicidad, las relaciones públicas, el desarrollo de estrategias de marketing, la gestión de medios digitales y la realiz',
                'status' => 'ACTIVE',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 =>
            array (
                'id' => 3,
            'name' => 'Tecnología de la Información (TI)',
                'description' => 'Se encarga de la gestión y el mantenimiento de los sistemas de tecnología de la empresa. Esto incluye la administración de redes, la seguridad informática, el desarrollo y mantenimiento de software, el soporte técnico y la implementación de soluciones tec',
                'status' => 'ACTIVE',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'Ventas',
                'description' => 'Es responsable de la generación de ingresos a través de la venta de productos o servicios. Esto implica la gestión de relaciones con los clientes, la generación de oportunidades de ventas, la negociación y cierre de contratos, el cumplimiento de objetivos',
                'status' => 'ACTIVE',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 =>
            array (
                'id' => 5,
                'name' => 'Operaciones',
                'description' => 'Gestiona las actividades diarias de la empresa para garantizar la eficiencia y la entrega de productos o servicios de calidad. Esto incluye la gestión de la cadena de suministro, la producción, la logística, la calidad, la gestión de proyectos y la mejora',
                'status' => 'ACTIVE',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 =>
            array (
                'id' => 6,
                'name' => 'Recursos Humanos',
                'description' => 'Se encarga de la gestión del personal de la empresa. Esto incluye reclutamiento y selección de empleados, administración de salarios y beneficios, desarrollo y capacitación del personal, gestión de relaciones laborales y cumplimiento de normas y regulacio',
                'status' => 'ACTIVE',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 =>
            array (
                'id' => 7,
                'name' => 'Servicio al Cliente',
                'description' => 'Responsable de atender las necesidades y consultas de los clientes. Esto implica la gestión de reclamaciones, la resolución de problemas, la atención al cliente, la gestión de quejas y la búsqueda de la satisfacción del cliente.',
                'status' => 'ACTIVE',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));


    }
}

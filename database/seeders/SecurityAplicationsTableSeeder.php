<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SecurityAplicationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        DB::table('security_aplications')->delete();

        DB::table('security_aplications')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Security',
                'description' => 'Aplicación para registro de aplicaciones, módulos, funcionalidades, usuarios y relación pertinente a cad uno de los elementos.',
                'icon' => 'fa-solid fa-shield-halved',
                'start_path' => 'Aplications',
                'order' => 1,
                'state' => 'ACTIVE',
                'created_at' => '2023-03-06 02:12:16',
                'updated_at' => '2023-05-01 01:49:55',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Veterinaria',
            'description' => 'Es un hecho establecido hace demasiado tiempo que un lector se distraerá con el contenido del texto de un sitio mientras que mira su diseño. El punto de usar Lorem Ipsum es que tiene una distribución más o menos normal de las letras, al contrario de usar textos como por ejemplo "Contenido aquí, contenido aquí". Estos textos hacen parecerlo un español que se puede leer. Muchos paquetes de autoedición y editores de páginas web usan el Lorem Ipsum como su texto por defecto, y al hacer una búsqueda de "Lorem Ipsum" va a dar por resultado muchos sitios web que usan este texto si se encuentran en estado de desarrollo. Muchas versiones han evolucionado a través de los años, algunas veces por accidente, otras veces a propósito (por ejemplo insertándole humor y cosas por el estilo).',
                'icon' => 'fa-solid fa-paw',
                'start_path' => 'Modules',
                'order' => 6,
                'state' => 'INACTIVE',
                'created_at' => '2023-03-06 02:22:24',
                'updated_at' => '2023-08-04 02:04:05',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'Human Talent',
                'description' => 'Aplicación para llevar el registro y mantenimiento de datos personales.',
                'icon' => 'fa-solid fa-people-group',
                'start_path' => 'Talento',
                'order' => 3,
                'state' => 'ACTIVE',
                'created_at' => '2023-04-16 00:50:54',
                'updated_at' => '2023-05-01 01:50:41',
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'Focus Your Life',
                'description' => 'Aplicación para registro a todo lo pertinente para una empresa de entrenamiento de potencial humano',
                'icon' => 'fa-solid fa-bullseye',
                'start_path' => 'Programs',
                'order' => 4,
                'state' => 'ACTIVE',
                'created_at' => '2023-04-16 00:53:22',
                'updated_at' => '2023-04-16 01:14:04',
            ),
            4 =>
            array (
                'id' => 5,
                'name' => 'Catalogs',
                'description' => 'Catálogos de uso general para todas las aplicaciones.',
                'icon' => 'icon-cogs',
                'start_path' => 'Catalogs',
                'order' => 2,
                'state' => 'ACTIVE',
                'created_at' => '2023-05-15 00:30:02',
                'updated_at' => '2023-05-15 00:33:13',
            ),
            5 =>
            array (
                'id' => 6,
                'name' => 'Clients',
                'description' => 'Registro de datos de clientes de la empresa',
                'icon' => 'icon-happy',
                'start_path' => 'Clients.index',
                'order' => 5,
                'state' => 'INACTIVE',
                'created_at' => '2023-05-20 19:52:48',
                'updated_at' => '2023-08-04 02:04:15',
            ),
        ));


    }
}

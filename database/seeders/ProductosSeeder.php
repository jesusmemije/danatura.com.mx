<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;


class ProductosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

          // Rows
          $rows= [];

          $rows[]=
            [
              'nombre'=>"Bebida de Coco",
              'sabor'=>"Coco Natural",
              'descripcion'=>"Bebida de pulpa de coco deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"168.00",
              'fotografia'=>"",
            ];
        
            $rows[]=
            [
              'nombre'=>"Bebida de Alpiste y Amaranto ",
              'sabor'=>"Alpiste con Amaranto",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            
            $rows[]=
            [
              'nombre'=>"Bebida de Coco y Quinoa",
              'sabor'=>"Coco con Quinoa",
              'descripcion'=>"Bebida de pulpa de Coco con Quinoa deshidratada en polvo (Rinde 2 litros ya hidratados) ",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Bebida de Alpiste, Amaranto y Cúrcuma",
              'sabor'=>"Alpiste Amaranto y Cúrcuma ",
              'descripcion'=>"Bebida de Apiste y Amaranto con Cúrcuma orgánica deshidratada en polvo (Rinde 2 litros ya hidratados) ",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Bebida Coco y Cacao",
              'sabor'=>"Coco con Cacao ",
              'descripcion'=>" Bebida de pulpa de coco con cacao orgánico deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Vegan Matcha Latte",
              'sabor'=>"Coco con Matcha ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Vegan Taro Latte ",
              'sabor'=>"Coco con Taro ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Vegan Berries Latte",
              'sabor'=>"Coco con Berries ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Vegan Carbón Activado  Latte",
              'sabor'=>"Coco con Carbon Activado ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Gelatina Vegana Coco",
              'sabor'=>"Coco Natural ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Gelatina Vegana Matcha ",
              'sabor'=>"Coco con Matcha ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Gelatina vegana de Taro  ",
              'sabor'=>"Coco con Taro ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Gelatina Vegana Coco Berries ",
              'sabor'=>"Coco con Berries ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Gelatina Vegana Coco Carbón Activado ",
              'sabor'=>"Coco con Carbon Activado ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Cápsulas Veganas de Carbón Activado",
              'sabor'=>"Carbón Activado",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Cápsulas Veganas de Cúrcuma, Jengibre y Pimienta de Cayena ",
              'sabor'=>"Curcuma Jengibre y Pimienta de Cayena ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Cápsulas Veganas de Camu Camu Orgánico ",
              'sabor'=>"Camu Camu ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Cápsulas Veganas de Maca Peruana ",
              'sabor'=>"Maca Peruana ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Cápsulas Veganas de Spirulina ",
              'sabor'=>"Alga Spirulina ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Cápsulas Veganas de Pasto de Trigo ",
              'sabor'=>"Pasto de Trigo (Wheat Grass) ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Cápsulas Veganas de Hercampuri ",
              'sabor'=>"Hercampuri Andino ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Cápsulas Veganas de Vinagre de Manzana ",
              'sabor'=>"Vinagre de Manzana ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Cápsulas Veganas de Moringa ",
              'sabor'=>"Moringa ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Cápsulas Veganas de Antioxidantes Frutos Rojos ",
              'sabor'=>"Antioxidantes Frutos Rojos ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Cápsulas Veganas de Betabel - Protector Celular ",
              'sabor'=>"Betabel ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Cápsulas Veganas de Equinacea - Sistema inmunológico y Respiratorio ",
              'sabor'=>"Echinacea Purpúrea ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Cápsulas Veganas de Matcha - Antioxidante verde ",
              'sabor'=>"Matcha Té Verde ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Cápsulas Veganas de inulina de agave - Prebiótico - Sistema Digestivo ",
              'sabor'=>"Inulina de Agave ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Cápsulas Veganas de Camote Morado - Antocianinas Protege el Corazón ",
              'sabor'=>"Camote Morado ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Cápsulas Veganas de Chorella . Clorofila - Detox ",
              'sabor'=>"Chlorella ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Cápsulas Veganas de Lúcuma - Energizante Natural ",
              'sabor'=>"Lúcuma ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Cápsulas Veganas de Frambuesa - Flavonoides Antiaging ",
              'sabor'=>"Frambuesa ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Cápsulas Veganas de Acaí Berry - Poder Antioxidante ",
              'sabor'=>"Acaí Berry ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Cápsulas Veganas de Goji Berry - Superalimento Antioxidante ",
              'sabor'=>"Goji Berry ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Cápsulas Veganas de Noni - Antiinflamatorio y Antioxidante Natural",
              'sabor'=>"Noni ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Cápsulas Veganas de Sacha inchi - Relajación y Bienestar ",
              'sabor'=>"Sacha Inchi ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Cápsulas Veganas de Cúrcuma - Desinflamatorio Natural ",
              'sabor'=>"Cúrcuma ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Cápsulas Veganas de Jengribre - Sistema Digestivo ",
              'sabor'=>"Jengibre ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Extracto De Estevia En Gotas ",
              'sabor'=>"Stevia Natural ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Azúcar Coco",
              'sabor'=>"Azúcar de coco ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Carbón Activado Pulverizado ",
              'sabor'=>"Carbón Activado ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Agar Agar En Polvo ",
              'sabor'=>"Agar Agar ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Extracto De Vainilla Pura Natural  ",
              'sabor'=>"Vainilla extracto ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];
            $rows[]=
            [
              'nombre'=>"Jugo Verde - Poder Verde  ",
              'sabor'=>"Jugo Verde",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];

            $rows[]=
            [
              'nombre'=>"Monk Fruit pulverizado ",
              'sabor'=>"Monk Fruit",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];

            $rows[]=
            [
              'nombre'=>"Golden Milk Mezcla para Leche Dorada ",
              'sabor'=>"Curcuma, Jengibre, Pimienta de cayena y Canela ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];

            $rows[]=
            [
              'nombre'=>"Azúcar de Dátil",
              'sabor'=>"Azúcar de Dátil ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];

            $rows[]=
            [
              'nombre'=>"Psillyum Husk en polvo ",
              'sabor'=>"Psyllium Husk Cáscara ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];

            $rows[]=
            [
              'nombre'=>"Psillyum Husk Cáscara ",
              'sabor'=>"Psyllium Husk en Polvo ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];

            $rows[]=
            [
              'nombre'=>"Tortillas De Quinoa ",
              'sabor'=>"Tortillas Quinoa ",
              'descripcion'=>"Bebida de Alpiste y Amaranto deshidratada en polvo (Rinde 2 litros ya hidratados)",
              'gramos'=>"250",
              'precio'=>"142",
              'fotografia'=>"",
            ];

              // Disable FKs & truncate table
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('productos')->truncate();

        // Date now
        $date = Carbon::now();

        // Create rows
        foreach($rows as $row)
        {
            DB::table('productos')->insert([
                'nombre'      => $row['nombre'],
                'sabor'       => $row['sabor'],
                'descripcion' => $row['descripcion'],
                'gramos'      => $row['gramos'],
                'precio'      => $row['precio'],
                'fotografia'  => $row['fotografia'],
                'created_at'  => $date,
                'updated_at'  => $date,
            ]);
        }

        // Enable FKs
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');



    }
}

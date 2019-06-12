<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PoiTableSeeder extends Seeder
{
    /**
     * @var string
     */
    const GDL_SOURCE_URL = 'https://download.data.grandlyon.com/wfs/rdata?SERVICE=WFS&VERSION=2.0.0&outputformat=GEOJSON&maxfeatures=6000&request=GetFeature&typename=sit_sitra.sittourisme&SRSNAME=urn:ogc:def:crs:EPSG::4171';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        echo "Downloading data from distant\n";
        $dataFromDistant = file_get_contents(self::GDL_SOURCE_URL);
        echo "Parsing data\n";
        /** @noinspection PhpComposerExtensionStubsInspection */
        $jsonData = json_decode($dataFromDistant);
        if (!empty($jsonData)) {
            echo "Successfully got data, first row is: {$jsonData->features[0]->properties->nom}\n";
            $this->storeData($jsonData);
        }
    }

    private function prepareString($string) : string
    {
        if (empty($string) || is_null($string)) return 'NULL';
        return "'" . addslashes($string) . "'";
    }

    private function prepareDouble($n)
    {
        if (empty($n) || is_null($n)) return NULL;
        return floatval($n);
    }

    private function prepareDateTime($date)
    {
        if (empty($n) || is_null($n)) return NULL;
        try {
            $val = new DateTime($date);
            return "'{$val->format("Y-m-d H:i:s")}'";
        } catch (Exception $e) {
            return NULL;
        }
    }

    private function storeData($data) : void
    {
        foreach($data->features as $key => $f) {
            DB::table('poi')->insert([
                "id" => $f->properties->id,
                "id_sitra1" => $this->prepareString($f->properties->id_sitra1),
                "type" => $this->prepareString($f->properties->type),
                "type_detail" => $this->prepareString($f->properties->type_detail),
                'name' => $this->prepareString($f->properties->nom),
                'address' => $this->prepareString($f->properties->adresse),
                'zip_code' => $f->properties->codepostal,
                'town' => $this->prepareString($f->properties->commune),
                'phone' => $this->prepareString($f->properties->telephone),
                'fax' => $this->prepareString($f->properties->fax),
                'fax_phone' => $this->prepareString($f->properties->telephonefax),
                'email' => $this->prepareString($f->properties->email),
                'website' => $this->prepareString($f->properties->siteweb),
                'facebook' => $this->prepareString($f->properties->facebook),
                'rank' => $this->prepareString($f->properties->classement),
                'opening_times' => $this->prepareString($f->properties->ouverture),
                'price' => $this->prepareString($f->properties->tarifsenclair),
                'pricemin' => $this->prepareDouble($f->properties->tarifsmin),
                'pricemax' => $this->prepareDouble($f->properties->tarifsmax),
                'author' => $this->prepareString($f->properties->producteur),
                'gid' => $f->properties->gid,
                'creation_date' => $this->prepareDateTime($f->properties->date_creation),
                'last_update' => $this->prepareDateTime($f->properties->last_update),
                'last_update_fme' => $this->prepareDateTime($f->properties->last_update_fme),
                'latitude' => $this->prepareDouble($f->geometry->coordinates[0]),
                'longitude' => $this->prepareDouble($f->geometry->coordinates[1]),
            ]);

            if ($key % 500 === 0) {
                echo "$key entries added in database\n";
            }
        }
    }
}
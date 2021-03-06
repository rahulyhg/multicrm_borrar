<?php

namespace Modules\Documents\Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Documents\Entities\Document;
use Modules\Documents\Entities\DocumentCategory;
use Modules\Documents\Entities\DocumentStatus;
use Modules\Documents\Entities\DocumentType;
use Modules\Platform\Core\Helper\SeederHelper;

class DocumentDemoSeederTableSeeder extends SeederHelper
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Document::truncate();

        \Auth::attempt(['email' => config('bap.demo_company_1'), 'password' => config('bap.demo_company_pass_1')]);


        for ($i = 1; $i <= 50; $i++) {
            $faker = Factory::create();

            $document = new Document();
            $document->id = $i;
            $document->changeOwnerTo(\Auth::user());

            $document->title = 'Company Report - ' . $faker->company;
            $document->notes = $faker->sentence();

            $document->document_type_id = DocumentType::where('company_id',$this->firstCompany())->get()->random(1)->first()->id;
            $document->document_status_id =  DocumentStatus::where('company_id',$this->firstCompany())->get()->random(1)->first()->id;
            $document->document_category_id = DocumentCategory::where('company_id',$this->firstCompany())->get()->random(1)->first()->id;

            $document->company_id = $this->firstCompany();

            $document->save();
        }

        \Auth::attempt(['email' => config('bap.demo_company_2'), 'password' => config('bap.demo_company_pass_2')]);

        for ($i = 51; $i <= 100; $i++) {
            $faker = Factory::create();

            $document = new Document();
            $document->id = $i;
            $document->changeOwnerTo(\Auth::user());

            $document->title = 'Company Report - ' . $faker->company;
            $document->notes = $faker->sentence();

            $document->document_type_id = DocumentType::where('company_id',$this->secondCompany())->get()->random(1)->first()->id;
            $document->document_status_id =  DocumentStatus::where('company_id',$this->secondCompany())->get()->random(1)->first()->id;
            $document->document_category_id = DocumentCategory::where('company_id',$this->secondCompany())->get()->random(1)->first()->id;


            $document->company_id = $this->secondCompany();

            $document->save();
        }
    }
}

<?php

/*
 * Example PHP implementation used for the index.html example
 */

// DataTables PHP library
include( "../../php/DataTables.php" );

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Mjoin,
	DataTables\Editor\Options,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate;

// Build our Editor instance and process the data coming from _POST
/*Editor::inst( $db, 'org_profiles' )
	->fields(
		Field::inst( 'first_name' )->validator( 'Validate::notEmpty' ),
		Field::inst( 'last_name' )->validator( 'Validate::notEmpty' ),
		Field::inst( 'position' ),
		Field::inst( 'email' ),
		Field::inst( 'office' ),
		Field::inst( 'extn' ),
		Field::inst( 'age' )
			->validator( 'Validate::numeric' )
			->setFormatter( 'Format::ifEmpty', null ),
		Field::inst( 'salary' )
			->validator( 'Validate::numeric' )
			->setFormatter( 'Format::ifEmpty', null ),
		Field::inst( 'start_date' )
			->validator( 'Validate::dateFormat', array(
				"format"  => Format::DATE_ISO_8601,
				"message" => "Please enter a date in the format yyyy-mm-dd"
			) )
			->getFormatter( 'Format::date_sql_to_format', Format::DATE_ISO_8601 )
			->setFormatter( 'Format::date_format_to_sql', Format::DATE_ISO_8601 )
	)
	->process( $_POST )
	->json();*/

Editor::inst( $db, 'org_profiles' , 'profile_id' )
//->pkey( 'profile_id' )
	->fields(
		Field::inst( 'org_profiles.profile_id' ),
		Field::inst( 'org_profiles.org_name' ),
		Field::inst( 'org_profiles.org_description' ),
		Field::inst( 'org_profiles.org_size' )
				->validator( 'Validate::dbValues' , array( 'table' => 'org_profiles',
					'field' => 'org_size',
					'message' => "Invalid Size" ) ),

		Field::inst( 'org_profiles.org_profile_status' )
				->validator( 'Validate::dbValues' , array( 'table' => 'org_profiles',
					'field' => 'org_profile_status',
					'message' => "Invalid Status" ) ),

		Field::inst( 'org_profiles.industry_id' )
				->validator( 'Validate::dbValues' , array( 'table' => 'org_profiles',
					'field' => 'industry_id',
					'message' => "Invalid Sector" ) ),

		Field::inst( 'org_profiles.industry_other' ),
		Field::inst( 'org_profiles.org_additional' ),

		Field::inst( 'org_profiles.org_confidence' )
				->validator( 'Validate::numeric' , array( 'table' => 'org_profiles',
					'field' => 'org_confidence',
					'message' => "Value not numeric" ) ),
		
		Field::inst( 'org_profiles.org_greatest_impact' )
				->validator( 'Validate::dbValues' , array( 'table' => 'org_profiles',
					'field' => 'org_greatest_impact',
					'message' => "Invalid Impact" ) ),
		
		Field::inst( 'org_profiles.org_greatest_impact_detail' ),
		
		Field::inst( 'org_profiles.org_profile_category' )
				->validator( 'Validate::dbValues' , array( 'table' => 'org_profiles',
					'field' => 'org_profile_category',
					'message' => "Invalid Type of Entry" ) ),
		
		Field::inst( 'org_profiles.org_profile_src' ),

		Field::inst( 'org_profiles.org_profile_year' ),

		Field::inst( 'org_profiles.org_type' )
				->validator( 'Validate::dbValues' , array( 'table' => 'org_profiles',
					'field' => 'org_type',
					'message' => "Invalid Type" ) ),

		Field::inst( 'org_profiles.org_type_other' ),
		Field::inst( 'org_profiles.org_url' ),
		Field::inst( 'org_profiles.org_year_founded' ),
		Field::inst( 'org_profiles.createdAt' ),
		Field::inst( 'org_profiles.updatedAt' ),
		Field::inst( 'org_profiles.machine_read' )
				->validator( 'Validate::dbValues' , array( 'table' => 'org_profiles',
					'field' => 'machine_read',
					'message' => "Invalid Machine-Readability" ) ),

/*		Field::inst( 'org_profiles.location_id' )
		        ->options( Options::inst()
                ->table( 'org_locations' )
                ->value( 'location_id' )
                ->label( 'org_hq_city' )
            )
            ->validator( 'Validate::dbValues' ), //Commented by Vinayak
            */
		Field::inst( 'org_locations.org_hq_city' ),
		Field::inst( 'org_locations.org_hq_st_prov' ),


		Field::inst( 'org_contacts.survey_contact_email' ),
		Field::inst( 'org_contacts.survey_contact_first' ),
		Field::inst( 'org_contacts.survey_contact_last' ),
		Field::inst( 'org_contacts.survey_contact_phone' ),
		Field::inst( 'org_contacts.survey_contact_title' ),
		
/*		Field::inst( 'org_profiles.country_id' )
		        ->options( Options::inst()
                ->table( 'org_country_info' )
                ->value( 'country_id' )
                ->label( 'org_hq_country' )
            )
            ->validator( 'Validate::dbValues' ),*/ //Commented by Vinayak

         Field::inst( 'org_country_info.org_hq_country' ),

         Field::inst( 'org_country_info.org_hq_country_income' ),
/*         Field::inst( 'org_country_info.org_hq_country_income_code' ),
         Field::inst( 'org_country_info.org_hq_country_locode' ),*/
         Field::inst( 'org_country_info.org_hq_country_region' ),
/*         Field::inst( 'org_country_info.org_hq_country_region_code' ),
         Field::inst( 'org_country_info.ISO2' ),*/
 		 Field::inst( 'org_country_info.c_lat' ),
         Field::inst( 'org_country_info.c_lon' ),

         Field::inst( 'data_applications.advocacy_desc' ),
         Field::inst( 'data_applications.org_opt_desc' ),
         Field::inst( 'data_applications.use_other_desc' ),
         Field::inst( 'data_applications.prod_srvc_desc' ),
         Field::inst( 'data_applications.research_desc' ),

         Field::inst( 'data_applications.advocacy' ),
         Field::inst( 'data_applications.org_opt' ),
         Field::inst( 'data_applications.use_other' ),
         Field::inst( 'data_applications.prod_srvc' ),
         Field::inst( 'data_applications.research' )
	)
	->leftJoin( 'org_locations', 'org_locations.location_id', '=', 'org_profiles.location_id' )
	->leftJoin( 'org_contacts', 'org_contacts.profile_id', '=', 'org_profiles.profile_id' )
	->leftJoin( 'org_country_info', 'org_country_info.country_id', '=', 'org_profiles.country_id' )
	->leftJoin( 'data_applications', 'data_applications.profile_id', '=', 'org_profiles.profile_id' )

	->join(
		Mjoin::inst( 'org_data_use' )
			->link( 'org_data_use.profile_id', 'org_profiles.profile_id' )
			//->link( 'permission.id', 'user_permission.permission_id' )
			//->order( 'name abs(number)sc' )
			->fields(
				Field::inst( 'object_id' )
					//->validator( 'Validate::required' )
					->options( Options::inst()
						->table( 'org_data_use' )
						->value( 'profile_id' )
						->label( 'data_type' )
					),
				Field::inst( 'data_type' )	
			)
	)
	->process( $_POST )
	->json();

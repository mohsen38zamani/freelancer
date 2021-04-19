<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RegisterRelationTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create the relation
        Schema::table('user_profile', function ($table) {
            $table->foreign('userid')->references('id')->on('users')->onDelete('RESTRICT');
            $table->foreign('countryid')->references('countryid')->on('country')->onDelete('RESTRICT');
            $table->foreign('translator_languageid')->references('id')->on('translator_languages')->onDelete('RESTRICT');
        });

        Schema::table('translator_translations', function ($table) {
            $table->foreign('locale')->references('locale')->on('translator_languages')->onDelete('RESTRICT');
//            $table->unique(['locale', 'namespace', 'group', 'item']);
        });

        Schema::table('field', function ($table) {
            $table->foreign('tabid')->references('tabid')->on('tab')->onDelete('RESTRICT');
            $table->foreign('blockid')->references('blockid')->on('block')->onDelete('RESTRICT');
        });

        Schema::table('skill', function ($table) {
            $table->foreign('lv1skillid')->references('lv1skillid')->on('lv1skill')->onDelete('RESTRICT');
        });

        Schema::table('lv2skill', function ($table) {
            $table->foreign('lv1skillid')->references('lv1skillid')->on('lv1skill')->onDelete('RESTRICT');
        });

        Schema::table('wage', function ($table) {
            $table->foreign('currencyid')->references('currencyid')->on('currency')->onDelete('RESTRICT');
        });

        Schema::table('project', function ($table) {
//            $table->foreign('advanceoptionid')->references('advanceoptionid')->on('advanceoption')->onDelete('RESTRICT');
            $table->foreign('wageid')->references('wageid')->on('wage')->onDelete('RESTRICT');
            $table->foreign('user_profileid')->references('user_profileid')->on('user_profile')->onDelete('RESTRICT');
            $table->foreign('assistant_settingid')->references('assistant_settingid')->on('assistant_setting')->onDelete('RESTRICT');
        });

        Schema::table('user_creditcard', function ($table) {
            $table->foreign('user_profileid')->references('user_profileid')->on('user_profile')->onDelete('RESTRICT');
        });

        Schema::table('user_socialmedia', function ($table) {
            $table->foreign('user_profileid')->references('user_profileid')->on('user_profile')->onDelete('RESTRICT');
            $table->foreign('socialmedialistid')->references('socialmedialistid')->on('socialmedialist')->onDelete('RESTRICT');
        });

        Schema::table('country', function ($table) {
            $table->foreign('currencyid')->references('currencyid')->on('currency')->onDelete('RESTRICT');
            $table->foreign('mainlandid')->references('mainlandid')->on('mainland')->onDelete('RESTRICT');
        });

        Schema::table('identity_card', function ($table) {
            $table->foreign('user_profileid')->references('user_profileid')->on('user_profile')->onDelete('RESTRICT');
        });

        Schema::table('address', function ($table) {
            $table->foreign('countryid')->references('countryid')->on('country')->onDelete('RESTRICT');
        });

        Schema::table('attachment', function ($table) {
            $table->foreign('tabid')->references('tabid')->on('tab')->onDelete('RESTRICT');
        });

        Schema::table('permission', function ($table) {
            $table->foreign('tabid')->references('tabid')->on('tab')->onDelete('RESTRICT');
            $table->foreign('roleid')->references('roleid')->on('role')->onDelete('RESTRICT');
        });

        Schema::table('item_menu', function ($table) {
            $table->foreign('menuid')->references('menuid')->on('menu')->onDelete('RESTRICT');
            $table->foreign('tabid')->references('tabid')->on('tab')->onDelete('RESTRICT');
        });

        Schema::table('tab_list_header', function($table)
        {
            $table->foreign('tabid')->references('tabid')->on('tab')->onDelete('RESTRICT');
            $table->unique(['tabid']);
        });

        Schema::table('systemtracker', function ($table) {
            $table->foreign('tabid')->references('tabid')->on('tab')->onDelete('RESTRICT');
            $table->foreign('user_profileid')->references('user_profileid')->on('user_profile')->onDelete('RESTRICT');
        });

        Schema::table('footeritem', function ($table) {
            $table->foreign('footermenuid')->references('footermenuid')->on('footermenu')->onDelete('RESTRICT');
        });

        Schema::table('contact_us', function ($table) {
            $table->foreign('lv1skillid')->references('lv1skillid')->on('lv1skill')->onDelete('RESTRICT');
        });

        Schema::table('news', function ($table) {
            $table->foreign('user_profileid')->references('user_profileid')->on('user_profile')->onDelete('RESTRICT');
        });

        Schema::table('language_resource', function ($table) {
            $table->foreign('tabid')->references('tabid')->on('tab')->onDelete('RESTRICT');
            $table->foreign('fieldid')->references('fieldid')->on('field')->onDelete('RESTRICT');
            $table->foreign('locale')->references('locale')->on('translator_languages')->onDelete('RESTRICT');
            $table->unique(['tabid', 'fieldid', 'locale', 'recordid']);
        });

        Schema::table('skill_requirment', function ($table) {
            $table->foreign('projectid')->references('projectid')->on('project')->onDelete('RESTRICT');
            $table->foreign('skillid')->references('skillid')->on('skill')->onDelete('RESTRICT');
        });

        Schema::table('freelancerinfo', function ($table) {
            $table->foreign('user_profileid')->references('user_profileid')->on('user_profile')->onDelete('RESTRICT');
            $table->foreign('experinceid')->references('experinceid')->on('experince')->onDelete('RESTRICT');
        });

        Schema::table('user_setting', function ($table) {
            $table->foreign('user_profileid')->references('user_profileid')->on('user_profile')->onDelete('RESTRICT');
        });

        Schema::table('skill_freelancer', function ($table) {
            $table->foreign('freelancerinfoid')->references('freelancerinfoid')->on('freelancerinfo')->onDelete('RESTRICT');
            $table->foreign('lv1skillid')->references('lv1skillid')->on('lv1skill')->onDelete('RESTRICT');
            $table->foreign('skillid')->references('skillid')->on('skill')->onDelete('RESTRICT');
        });

        Schema::table('portfolio', function ($table) {
            $table->foreign('user_profileid')->references('user_profileid')->on('user_profile')->onDelete('RESTRICT');
        });

        Schema::table('portfolio_skill', function ($table) {
            $table->foreign('portfolioid')->references('portfolioid')->on('portfolio')->onDelete('RESTRICT');
            $table->foreign('skillid')->references('skillid')->on('skill')->onDelete('RESTRICT');
        });

        Schema::table('assistant_setting', function ($table) {
            $table->foreign('currencyid')->references('currencyid')->on('currency')->onDelete('RESTRICT');
        });

        Schema::table('project_advanceoption', function ($table) {
            $table->foreign('advanceoptionid')->references('advanceoptionid')->on('advanceoption')->onDelete('RESTRICT');
            $table->foreign('projectid')->references('projectid')->on('project')->onDelete('RESTRICT');
        });

        Schema::table('job_experience', function ($table) {
            $table->foreign('user_profileid')->references('user_profileid')->on('user_profile')->onDelete('RESTRICT');
        });

        Schema::table('education', function ($table) {
            $table->foreign('user_profileid')->references('user_profileid')->on('user_profile')->onDelete('RESTRICT');
            $table->foreign('countryid')->references('countryid')->on('country')->onDelete('RESTRICT');
        });

        Schema::table('qualification', function ($table) {
            $table->foreign('user_profileid')->references('user_profileid')->on('user_profile')->onDelete('RESTRICT');
        });

        Schema::table('publication', function ($table) {
            $table->foreign('user_profileid')->references('user_profileid')->on('user_profile')->onDelete('RESTRICT');
        });

        Schema::table('faq', function ($table) {
            $table->foreign('roleid')->references('roleid')->on('role')->onDelete('RESTRICT');
        });

        Schema::table('user_verification_items', function ($table) {
            $table->foreign('user_profileid')->references('user_profileid')->on('user_profile')->onDelete('RESTRICT');
        });

        Schema::table('verify_user', function ($table) {
            $table->foreign('user_profileid')->references('user_profileid')->on('user_profile')->onDelete('RESTRICT');
        });

        Schema::table('bids_project', function ($table) {
            $table->foreign('projectid')->references('projectid')->on('project')->onDelete('RESTRICT');
            $table->foreign('user_profileid')->references('user_profileid')->on('user_profile')->onDelete('RESTRICT');
        });

        Schema::table('mile_stone', function ($table) {
            $table->foreign('bids_projectid')->references('bids_projectid')->on('bids_project')->onDelete('RESTRICT');
        });

        Schema::table('manage_project', function ($table) {
            $table->foreign('projectid')->references('projectid')->on('project')->onDelete('RESTRICT');
            $table->foreign('bids_projectid')->references('bids_projectid')->on('bids_project')->onDelete('RESTRICT');
        });

        Schema::table('payment_bill', function ($table) {
            $table->foreign('roll_billid')->references('roll_billid')->on('roll_bill')->onDelete('RESTRICT');
        });

        Schema::table('transaction', function ($table) {
            $table->foreign('user_profileid')->references('user_profileid')->on('user_profile')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

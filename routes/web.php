<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
//Route::get('/', function () {});
Route::get('locale/{locale}', function ($locale){
    Session::put('locale', $locale);
    return redirect()->back();
});
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'IndexController@welcome')->name('index');
Route::get('/skills', 'IndexController@skills')->name('skills');
Route::post('/public_search', 'IndexController@public_search')->name('public_search');
/*
* admin panel
*/
Route::get('/dashboard', 'PanelController@home')->name('Dashboard');
Route::post('/getChild', 'PublicClass\PublicControllerFunction@getChild')->name('Get_Child');

//---------> setting
Route::post('/setting/change_password', 'Company_infoController@change_password')->name('Setting_change_password');

//---------> company_info
Route::get('/company_info/edit', 'Company_infoController@edit')->name('Company_info_Edit');
Route::post('/company_info/edit', 'Company_infoController@save')->name('Company_info_Save');

//---------> user_profile
Route::get('/user_profile/list', 'User_profileController@list')->name('User_profile_List');
Route::get('/user_profile/new', 'User_profileController@new')->name('User_profile_New');
Route::post('/user_profile/new', 'User_profileController@store')->name('User_profile_Store');
Route::get('/user_profile/edit/{id}', 'User_profileController@edit')->name('User_profile_Edit');
Route::post('/user_profile/edit', 'User_profileController@save')->name('User_profile_Save');
Route::get('/user_profile/delete/{ids}', 'User_profileController@delete')->name('User_profile_Delete');
Route::get('/user_profile/details/{id}', 'User_profileController@details')->name('User_profile_Details');
Route::get('/user_profile/details/{id}/{rel}', 'User_profileController@relation')->name('User_profile_Relation');
Route::post('/user_profile/deleteattachment', 'User_profileController@deleteattachment')->name('User_profile_delete_attachment');

//---------> user_transactions
Route::get('/user_transactions/list', 'User_profileController@transactionslist')->name('user_transactions_List');

//---------> translator
Route::get('/translator/list', 'TranslatorController@list')->name('Translator_List');
Route::get('/translator/new', 'TranslatorController@new')->name('Translator_New');
Route::post('/translator/new', 'TranslatorController@store')->name('Translator_Store');
Route::get('/translator/edit/{id}', 'TranslatorController@edit')->name('Translator_Edit');
Route::post('/translator/edit', 'TranslatorController@save')->name('Translator_Save');
Route::get('/translator/delete/{ids}', 'TranslatorController@delete')->name('Translator_Delete');
Route::get('/translator/details/{id}', 'TranslatorController@details')->name('Translator_Details');
Route::get('/translator/details/{id}/{rel}', 'TranslatorController@relation')->name('Translator_Relation');
Route::post('/translator/deleteattachment', 'TranslatorController@deleteattachment')->name('Translator_delete_attachment');

//---------> Lv1skill
Route::get('/lv1skill/list', 'Lv1skillController@list')->name('Lv1skill_List');
Route::get('/lv1skill/new', 'Lv1skillController@new')->name('Lv1skill_New');
Route::post('/lv1skill/new', 'Lv1skillController@store')->name('Lv1skill_Store');
Route::get('/lv1skill/edit/{id}', 'Lv1skillController@edit')->name('Lv1skill_Edit');
Route::post('/lv1skill/edit', 'Lv1skillController@save')->name('Lv1skill_Save');
Route::get('/lv1skill/delete/{ids}', 'Lv1skillController@delete')->name('Lv1skill_Delete');
Route::get('/lv1skill/details/{id}', 'Lv1skillController@details')->name('Lv1skill_Details');
Route::get('/lv1skill/details/{id}/{rel}', 'Lv1skillController@relation')->name('Lv1skill_Relation');
Route::post('/lv1skill/deleteattachment', 'Lv1skillController@deleteattachment')->name('Lv1skill_delete_attachment');

//---------> lv2skill
Route::get('/lv2skill/list', 'Lv2skillController@list')->name('Lv2skill_List');
Route::get('/lv2skill/new', 'Lv2skillController@new')->name('Lv2skill_New');
Route::post('/lv2skill/new', 'Lv2skillController@store')->name('Lv2skill_Store');
Route::get('/lv2skill/edit/{id}', 'Lv2skillController@edit')->name('Lv2skill_Edit');
Route::post('/lv2skill/edit', 'Lv2skillController@save')->name('Lv2skill_Save');
Route::get('/lv2skill/delete/{ids}', 'Lv2skillController@delete')->name('Lv2skill_Delete');
Route::get('/lv2skill/details/{id}', 'Lv2skillController@details')->name('Lv2skill_Details');
Route::get('/lv2skill/details/{id}/{rel}', 'Lv2skillController@relation')->name('Lv2skill_Relation');
Route::post('/lv2skill/deleteattachment', 'Lv2skillController@deleteattachment')->name('Lv2skill_delete_attachment');

//---------> skill
Route::get('/skill/list', 'SkillController@list')->name('Skill_List');
Route::get('/skill/new', 'SkillController@new')->name('Skill_New');
Route::post('/skill/new', 'SkillController@store')->name('Skill_Store');
Route::get('/skill/edit/{id}', 'SkillController@edit')->name('Skill_Edit');
Route::post('/skill/edit', 'SkillController@save')->name('Skill_Save');
Route::get('/skill/delete/{ids}', 'SkillController@delete')->name('Skill_Delete');
Route::get('/skill/details/{id}', 'SkillController@details')->name('Skill_Details');
Route::get('/skill/details/{id}/{rel}', 'SkillController@relation')->name('Skill_Relation');
Route::post('/skill/deleteattachment', 'SkillController@deleteattachment')->name('Skill_delete_attachment');

//---------> mainland
Route::get('/mainland/list', 'MainlandController@list')->name('mainland_List');
Route::get('/mainland/new', 'MainlandController@new')->name('mainland_New');
Route::post('/mainland/new', 'MainlandController@store')->name('mainland_Store');
Route::get('/mainland/edit/{id}', 'MainlandController@edit')->name('mainland_Edit');
Route::post('/mainland/edit', 'MainlandController@save')->name('mainland_Save');
Route::get('/mainland/delete/{ids}', 'MainlandController@delete')->name('mainland_Delete');
Route::get('/mainland/details/{id}', 'MainlandController@details')->name('mainland_Details');
Route::get('/mainland/details/{id}/{rel}', 'MainlandController@relation')->name('mainland_Relation');
Route::post('/mainland/deleteattachment', 'MainlandController@deleteattachment')->name('mainland_delete_attachment');

//---------> currency
Route::get('/currency/list', 'CurrencyController@list')->name('currency_List');
Route::get('/currency/new', 'CurrencyController@new')->name('currency_New');
Route::post('/currency/new', 'CurrencyController@store')->name('currency_Store');
Route::get('/currency/edit/{id}', 'CurrencyController@edit')->name('currency_Edit');
Route::post('/currency/edit', 'CurrencyController@save')->name('currency_Save');
Route::get('/currency/delete/{ids}', 'CurrencyController@delete')->name('currency_Delete');
Route::get('/currency/details/{id}', 'CurrencyController@details')->name('currency_Details');
Route::get('/currency/details/{id}/{rel}', 'CurrencyController@relation')->name('currency_Relation');
Route::post('/currency/deleteattachment', 'CurrencyController@deleteattachment')->name('currency_delete_attachment');

//---------> country
Route::get('/country/list', 'CountryController@list')->name('country_List');
Route::get('/country/new', 'CountryController@new')->name('country_New');
Route::post('/country/new', 'CountryController@store')->name('country_Store');
Route::get('/country/edit/{id}', 'CountryController@edit')->name('country_Edit');
Route::post('/country/edit', 'CountryController@save')->name('country_Save');
Route::get('/country/delete/{ids}', 'CountryController@delete')->name('country_Delete');
Route::get('/country/details/{id}', 'CountryController@details')->name('country_Details');
Route::get('/country/details/{id}/{rel}', 'CountryController@relation')->name('country_Relation');
Route::post('/country/deleteattachment', 'CountryController@deleteattachment')->name('country_delete_attachment');

//---------> certificationlist
Route::get('/certificationlist/list', 'CertificationlistController@list')->name('certificationlist_List');
Route::get('/certificationlist/new', 'CertificationlistController@new')->name('certificationlist_New');
Route::post('/certificationlist/new', 'CertificationlistController@store')->name('certificationlist_Store');
Route::get('/certificationlist/edit/{id}', 'CertificationlistController@edit')->name('certificationlist_Edit');
Route::post('/certificationlist/edit', 'CertificationlistController@save')->name('certificationlist_Save');
Route::get('/certificationlist/delete/{ids}', 'CertificationlistController@delete')->name('certificationlist_Delete');
Route::get('/certificationlist/details/{id}', 'CertificationlistController@details')->name('certificationlist_Details');
Route::get('/certificationlist/details/{id}/{rel}', 'CertificationlistController@relation')->name('certificationlist_Relation');
Route::post('/certificationlist/deleteattachment', 'CertificationlistController@deleteattachment')->name('certificationlist_delete_attachment');

//---------> socialmedialist
Route::get('/socialmedialist/list', 'SocialmedialistController@list')->name('socialmedialist_List');
Route::get('/socialmedialist/new', 'SocialmedialistController@new')->name('socialmedialist_New');
Route::post('/socialmedialist/new', 'SocialmedialistController@store')->name('socialmedialist_Store');
Route::get('/socialmedialist/edit/{id}', 'SocialmedialistController@edit')->name('socialmedialist_Edit');
Route::post('/socialmedialist/edit', 'SocialmedialistController@save')->name('socialmedialist_Save');
Route::get('/socialmedialist/delete/{ids}', 'SocialmedialistController@delete')->name('socialmedialist_Delete');
Route::get('/socialmedialist/details/{id}', 'SocialmedialistController@details')->name('socialmedialist_Details');
Route::get('/socialmedialist/details/{id}/{rel}', 'SocialmedialistController@relation')->name('socialmedialist_Relation');
Route::post('/socialmedialist/deleteattachment', 'SocialmedialistController@deleteattachment')->name('socialmedialist_delete_attachment');

//---------> advanceoption
Route::get('/advanceoption/list', 'AdvanceoptionController@list')->name('advanceoption_List');
Route::get('/advanceoption/new', 'AdvanceoptionController@new')->name('advanceoption_New');
Route::post('/advanceoption/new', 'AdvanceoptionController@store')->name('advanceoption_Store');
Route::get('/advanceoption/edit/{id}', 'AdvanceoptionController@edit')->name('advanceoption_Edit');
Route::post('/advanceoption/edit', 'AdvanceoptionController@save')->name('advanceoption_Save');
Route::get('/advanceoption/delete/{ids}', 'AdvanceoptionController@delete')->name('advanceoption_Delete');
Route::get('/advanceoption/details/{id}', 'AdvanceoptionController@details')->name('advanceoption_Details');
Route::get('/advanceoption/details/{id}/{rel}', 'AdvanceoptionController@relation')->name('advanceoption_Relation');
Route::post('/advanceoption/deleteattachment', 'AdvanceoptionController@deleteattachment')->name('advanceoption_delete_attachment');

//---------> slider
Route::get('/slider/list', 'SliderController@list')->name('slider_List');
Route::get('/slider/new', 'SliderController@new')->name('slider_New');
Route::post('/slider/new', 'SliderController@store')->name('slider_Store');
Route::get('/slider/edit/{id}', 'SliderController@edit')->name('slider_Edit');
Route::post('/slider/edit', 'SliderController@save')->name('slider_Save');
Route::get('/slider/delete/{ids}', 'SliderController@delete')->name('slider_Delete');
Route::get('/slider/details/{id}', 'SliderController@details')->name('slider_Details');
Route::get('/slider/details/{id}/{rel}', 'SliderController@relation')->name('slider_Relation');
Route::post('/slider/deleteattachment', 'SliderController@deleteattachment')->name('slider_delete_attachment');

//---------> footermenu
Route::get('/footermenu/list', 'FootermenuController@list')->name('footermenu_List');
Route::get('/footermenu/new', 'FootermenuController@new')->name('footermenu_New');
Route::post('/footermenu/new', 'FootermenuController@store')->name('footermenu_Store');
Route::get('/footermenu/edit/{id}', 'FootermenuController@edit')->name('footermenu_Edit');
Route::post('/footermenu/edit', 'FootermenuController@save')->name('footermenu_Save');
Route::get('/footermenu/delete/{ids}', 'FootermenuController@delete')->name('footermenu_Delete');
Route::get('/footermenu/details/{id}', 'FootermenuController@details')->name('footermenu_Details');
Route::get('/footermenu/details/{id}/{rel}', 'FootermenuController@relation')->name('footermenu_Relation');
Route::post('/footermenu/deleteattachment', 'FootermenuController@deleteattachment')->name('footermenu_delete_attachment');

//---------> footeritem
Route::get('/footeritem/list', 'FooteritemController@list')->name('footeritem_List');
Route::get('/footeritem/new', 'FooteritemController@new')->name('footeritem_New');
Route::post('/footeritem/new', 'FooteritemController@store')->name('footeritem_Store');
Route::get('/footeritem/edit/{id}', 'FooteritemController@edit')->name('footeritem_Edit');
Route::post('/footeritem/edit', 'FooteritemController@save')->name('footeritem_Save');
Route::get('/footeritem/delete/{ids}', 'FooteritemController@delete')->name('footeritem_Delete');
Route::get('/footeritem/details/{id}', 'FooteritemController@details')->name('footeritem_Details');
Route::get('/footeritem/details/{id}/{rel}', 'FooteritemController@relation')->name('footeritem_Relation');
Route::post('/footeritem/deleteattachment', 'FooteritemController@deleteattachment')->name('footeritem_delete_attachment');

//---------> faq
Route::get('/faq/list', 'FaqController@list')->name('faq_List');
Route::get('/faq/new', 'FaqController@new')->name('faq_New');
Route::post('/faq/new', 'FaqController@store')->name('faq_Store');
Route::get('/faq/edit/{id}', 'FaqController@edit')->name('faq_Edit');
Route::post('/faq/edit', 'FaqController@save')->name('faq_Save');
Route::get('/faq/delete/{ids}', 'FaqController@delete')->name('faq_Delete');
Route::get('/faq/details/{id}', 'FaqController@details')->name('faq_Details');
Route::get('/faq/details/{id}/{rel}', 'FaqController@relation')->name('faq_Relation');
Route::post('/faq/deleteattachment', 'FaqController@deleteattachment')->name('faq_delete_attachment');

//---------> news
Route::get('/news/list', 'NewsController@list')->name('news_List');
Route::get('/news/new', 'NewsController@new')->name('news_New');
Route::post('/news/new', 'NewsController@store')->name('news_Store');
Route::get('/news/edit/{id}', 'NewsController@edit')->name('news_Edit');
Route::post('/news/edit', 'NewsController@save')->name('news_Save');
Route::get('/news/delete/{ids}', 'NewsController@delete')->name('news_Delete');
Route::get('/news/details/{id}', 'NewsController@details')->name('news_Details');
Route::get('/news/details/{id}/{rel}', 'NewsController@relation')->name('news_Relation');
Route::post('/news/deleteattachment', 'NewsController@deleteattachment')->name('news_delete_attachment');

//---------> tab_list_header
Route::get('/tab_list_header/list', 'Tab_list_headerController@list')->name('tab_list_header_List');
Route::get('/tab_list_header/new', 'Tab_list_headerController@new')->name('tab_list_header_New');
Route::post('/tab_list_header/new', 'Tab_list_headerController@store')->name('tab_list_header_Store');
Route::get('/tab_list_header/edit/{id}', 'Tab_list_headerController@edit')->name('tab_list_header_Edit');
Route::post('/tab_list_header/edit', 'Tab_list_headerController@save')->name('tab_list_header_Save');
Route::get('/tab_list_header/delete/{ids}', 'Tab_list_headerController@delete')->name('tab_list_header_Delete');
Route::get('/tab_list_header/details/{id}', 'Tab_list_headerController@details')->name('tab_list_header_Details');
Route::get('/tab_list_header/details/{id}/{rel}', 'Tab_list_headerController@relation')->name('tab_list_header_Relation');
Route::post('/tab_list_header/deleteattachment', 'Tab_list_headerController@deleteattachment')->name('tab_list_header_delete_attachment');
Route::post('/tab_list_header/getChild', 'Tab_list_headerController@getChild')->name('Get_Child');

//---------> field
Route::get('/field/list', 'FieldController@list')->name('field_List');
Route::get('/field/new', 'FieldController@new')->name('field_New');
Route::post('/field/new', 'FieldController@store')->name('field_Store');
Route::get('/field/edit/{id}', 'FieldController@edit')->name('field_Edit');
Route::post('/field/edit', 'FieldController@save')->name('field_Save');
Route::get('/field/delete/{ids}', 'FieldController@delete')->name('field_Delete');
Route::get('/field/details/{id}', 'FieldController@details')->name('field_Details');
Route::get('/field/details/{id}/{rel}', 'FieldController@relation')->name('field_Relation');
Route::post('/field/deleteattachment', 'FieldController@deleteattachment')->name('field_delete_attachment');

//---------> wage
Route::get('/wage/list', 'WageController@list')->name('wage_List');
Route::get('/wage/new', 'WageController@new')->name('wage_New');
Route::post('/wage/new', 'WageController@store')->name('wage_Store');
Route::get('/wage/edit/{id}', 'WageController@edit')->name('wage_Edit');
Route::post('/wage/edit', 'WageController@save')->name('wage_Save');
Route::get('/wage/delete/{ids}', 'WageController@delete')->name('wage_Delete');
Route::get('/wage/details/{id}', 'WageController@details')->name('wage_Details');
Route::get('/wage/details/{id}/{rel}', 'WageController@relation')->name('wage_Relation');
Route::post('/wage/deleteattachment', 'WageController@deleteattachment')->name('wage_delete_attachment');

//---------> assistant_setting
Route::get('/assistant_setting/list', 'Assistant_settingController@list')->name('assistant_setting_List');
Route::get('/assistant_setting/new', 'Assistant_settingController@new')->name('assistant_setting_New');
Route::post('/assistant_setting/new', 'Assistant_settingController@store')->name('assistant_setting_Store');
Route::get('/assistant_setting/edit/{id}', 'Assistant_settingController@edit')->name('assistant_setting_Edit');
Route::post('/assistant_setting/edit', 'Assistant_settingController@save')->name('assistant_setting_Save');
Route::get('/assistant_setting/delete/{ids}', 'Assistant_settingController@delete')->name('assistant_setting_Delete');
Route::get('/assistant_setting/details/{id}', 'Assistant_settingController@details')->name('assistant_setting_Details');
Route::get('/assistant_setting/details/{id}/{rel}', 'Assistant_settingController@relation')->name('assistant_setting_Relation');
Route::post('/assistant_setting/deleteattachment', 'Assistant_settingController@deleteattachment')->name('assistant_setting_delete_attachment');

//----------> social redirect
Route::get('/auth/redirect/{provider}', 'SocialController@redirect');
Route::get('/auth/{provider}/callback', 'SocialController@callback');

//-----------> wizard signup
Route::get('/Username', 'SignupManagementController@Username')->name('Username');
Route::post('/Username', 'SignupManagementController@username_validate')->name('validateUsername');
Route::get('/Username=^s', 'SignupManagementController@username_selectType')->name('selectType');
Route::get('/developer', 'SignupManagementController@selectDeveloper')->name('developer');
Route::get('/employer', 'SignupManagementController@selectEmployer')->name('employer');

//---------> profile
Route::get('/profile', 'site\ProfileController@login')->name('Profile_login');
Route::get('/profile/{username}', 'site\ProfileController@profile')->name('Profile');
Route::get('/profile/{username}/edit', 'site\ProfileController@edit')->name('Edit_Profile');
Route::post('/profile/edit/', 'site\ProfileController@save')->name('save_Edit_Profile');
Route::post('/profile/edit/change_password', 'site\ProfileController@change_password')->name('change_password_Profile');
Route::post('/profile/edit/account', 'site\ProfileController@edit_account')->name('Edit_Profile');
Route::post('/profile/cover', 'site\ProfileController@cover')->name('cover');
Route::post('/profile/avatar', 'site\ProfileController@avatar')->name('cover');

//---------> portfolio
Route::get('/portfolio/{username}/list', 'site\PortfolioController@list')->name('portfolio_List');
Route::get('/portfolio/new', 'site\PortfolioController@new')->name('portfolio_New');
Route::post('/portfolio/new', 'site\PortfolioController@store')->name('portfolio_Store');
Route::get('/portfolio/edit/{id}', 'site\PortfolioController@edit')->name('portfolio_Edit');
Route::get('/portfolio/view/{id}', 'site\PortfolioController@view')->name('portfolio_Edit');
Route::post('/portfolio/edit', 'site\PortfolioController@save')->name('portfolio_Save');
Route::get('/portfolio/delete/{ids}', 'site\PortfolioController@delete')->name('portfolio_Delete');
Route::post('/portfolio/deleteattachment', 'site\PortfolioController@deleteattachment')->name('portfolio_delete_attachment');

//---------> job_experience
Route::get('/job_experience/list', 'site\Job_experienceController@list')->name('job_experience_List');
Route::get('/job_experience/new', 'site\Job_experienceController@new')->name('job_experience_New');
Route::post('/job_experience/new', 'site\Job_experienceController@store')->name('job_experience_Store');
Route::get('/job_experience/edit/{id}', 'site\Job_experienceController@edit')->name('job_experience_Edit');
Route::get('/job_experience/view/{id}', 'site\Job_experienceController@view')->name('job_experience_Edit');
Route::post('/job_experience/edit', 'site\Job_experienceController@save')->name('job_experience_Save');
Route::get('/job_experience/delete/{ids}', 'site\Job_experienceController@delete')->name('job_experience_Delete');
Route::post('/job_experience/deleteattachment', 'site\Job_experienceController@deleteattachment')->name('job_experience_delete_attachment');

//---------> publication
Route::get('/publication/list', 'site\PublicationController@list')->name('publication_List');
Route::get('/publication/new', 'site\PublicationController@new')->name('publication_New');
Route::post('/publication/new', 'site\PublicationController@store')->name('publication_Store');
Route::get('/publication/edit/{id}', 'site\PublicationController@edit')->name('publication_Edit');
Route::get('/publication/view/{id}', 'site\PublicationController@view')->name('publication_Edit');
Route::post('/publication/edit', 'site\PublicationController@save')->name('publication_Save');
Route::get('/publication/delete/{ids}', 'site\PublicationController@delete')->name('publication_Delete');
Route::post('/publication/deleteattachment', 'site\PublicationController@deleteattachment')->name('publication_delete_attachment');

//---------> qualification
Route::get('/qualification/list', 'site\QualificationController@list')->name('qualification_List');
Route::get('/qualification/new', 'site\QualificationController@new')->name('qualification_New');
Route::post('/qualification/new', 'site\QualificationController@store')->name('qualification_Store');
Route::get('/qualification/edit/{id}', 'site\QualificationController@edit')->name('qualification_Edit');
Route::get('/qualification/view/{id}', 'site\QualificationController@view')->name('qualification_Edit');
Route::post('/qualification/edit', 'site\QualificationController@save')->name('qualification_Save');
Route::get('/qualification/delete/{ids}', 'site\QualificationController@delete')->name('qualification_Delete');
Route::post('/qualification/deleteattachment', 'site\QualificationController@deleteattachment')->name('qualification_delete_attachment');

//---------> faq
Route::get('/faq/help', 'FaqController@sitelist')->name('help_List');
Route::get('/faq/help/{id}', 'FaqController@siteitemshow')->name('help_show');

//---------> education
Route::get('/education/list', 'site\EducationController@list')->name('education_List');
Route::get('/education/new', 'site\EducationController@new')->name('education_New');
Route::post('/education/new', 'site\EducationController@store')->name('education_Store');
Route::get('/education/edit/{id}', 'site\EducationController@edit')->name('education_Edit');
Route::get('/education/view/{id}', 'site\EducationController@view')->name('education_Edit');
Route::post('/education/edit', 'site\EducationController@save')->name('education_Save');
Route::get('/education/delete/{ids}', 'site\EducationController@delete')->name('education_Delete');
Route::post('/education/deleteattachment', 'site\EducationController@deleteattachment')->name('education_delete_attachment');

Route::post('/skill', 'SkillManagementController@saveSkill')->name('getSkillSelect');
Route::get('/skill', 'SkillManagementController@selectSkill')->name('skill_select');
Route::get('/UserInfo', 'signupManagementController@show_infoFreeLancer')->name('UserInfo');
Route::post('/UserInfo', 'signupManagementController@saveUserinfo')->name('UserInfo');
Route::post('/getCountry', 'signupManagementController@getCountry')->name('getCountry');
Route::get('/dashboardUser', function (){ return redirect('/profile'); })->name('dashboardUser');

//---------> postProject
Route::get('/postProject/list', 'site\ProjectController@list')->name('postProject_List');
Route::get('/postProject', 'site\ProjectController@new')->name('postProject_New');
Route::post('/postProject/new', 'site\ProjectController@store')->name('postProject_Store');
Route::get('/postProject/edit/{id}', 'site\ProjectController@edit')->name('postProject_Edit');
Route::post('/postProject/edit', 'site\ProjectController@save')->name('postProject_Save');
Route::get('/postProject/delete/{ids}', 'site\ProjectController@delete')->name('postProject_Delete');
Route::post('/postProject/deleteattachment', 'site\ProjectController@deleteattachment')->name('postProject_delete_attachment');
Route::post('/get_Wage_assistantSetting', 'site\ProjectController@getWage')->name('get_Wage_assistantSetting');

//---------> page contact
Route::get('/contact', 'site\ContactController@new')->name('contact');
Route::post('/contact/new', 'site\ContactController@store')->name('contact_Store');

//---------> page contact
Route::get('/help', 'site\HelpController@show')->name('help');

//---------> page project-detail
Route::get('/project-detail/{id}', 'site\ProjectDetailController@detail')->name('project-detail');
Route::get('/project-detail/file/{id}', 'site\ProjectDetailController@file')->name('project-detail-file');
Route::get('/project-detail/edit/{id}', 'site\ProjectDetailController@edit')->name('project-edit');
Route::get('/project-detail/proposal/{id}', 'site\ProjectDetailController@proposal')->name('project-proposal');
Route::post('/project-detail/save', 'site\ProjectDetailController@save')->name('project-save');
Route::post('/project-detail/save_advanceOption', 'site\ProjectDetailController@save_advanceOption')->name('project-save_advanceOption');
Route::post('/project-detail/delete', 'site\ProjectDetailController@delete')->name('project-detail_Delete');
Route::post('/project-detail/close', 'site\ProjectDetailController@close')->name('project-detail_close');
Route::post('/project-delete/file', 'site\ProjectDetailController@deleteFile')->name('project-Delete-file');
Route::post('/detail_bid/freelancer', 'site\ProjectDetailController@detail_bid_freelancer')->name('detail_bid_freelancer');
Route::post('/request-freelancer/payment', 'site\ProjectDetailController@payment_milestone')->name('payment_milestone');

//---------> page project-request
Route::get('/project-request/{id}', 'site\ProjectDetailController@requestProject')->name('project-requestProject');
Route::post('/saveSkillFreelancer', 'site\ProjectDetailController@saveSkillFreelancer')->name('project-saveSkillFreelancer');
Route::post('/checkEmailVerify', 'site\ProjectDetailController@checkEmailVerify')->name('checkEmailVerify');
Route::post('/updateUserProfile', 'site\ProjectDetailController@updateUserProfile')->name('updateUserProfile');
Route::post('/saveBidProject', 'site\ProjectDetailController@saveBidProject')->name('saveBidProject');

//---------> page project-proposal
Route::get('/project-proposal/{id}', 'site\ProjectDetailController@proposalFreelancer')->name('proposal');
Route::post('/request-freelancer/list', 'site\ProjectDetailController@list_proposal')->name('proposal-list');
Route::post('/request-freelancer/delete', 'site\ProjectDetailController@delete_proposal')->name('proposal-delete');

//---------> page main-project
Route::get('/all-project', 'site\ProjectMainController@showAll')->name('project-showAll');
Route::post('/all-project/getProjectList', 'site\ProjectMainController@getProjectList')->name('getProjectList');
Route::post('/project-ending', 'site\ProjectMainController@project_ending')->name('project-ending');

//---------> page browse project
Route::get('/browse-project', 'site\BrowsProjectController@showAll')->name('browse-project');
Route::post('/browse-project/list', 'site\BrowsProjectController@list')->name('browse-project-list');

//---------> page brows freelancer
Route::get('/browse-freelancer', 'site\BrowsFreelancerController@showAll')->name('browse-freelancer');
Route::post('/browse-freelancer/list', 'site\BrowsFreelancerController@list')->name('browse-freelancer-list');
Route::post('/browse-freelancer/chat_request', 'site\BrowsFreelancerController@chat_request')->name('browse-freelancer-chat-request');

//---------> user_verification_items
Route::get('/user_verification_items/list', 'site\User_verification_itemsController@list')->name('user_verification_items_List');
Route::get('/user_verification_items/new', 'site\User_verification_itemsController@new')->name('user_verification_items_New');
Route::post('/user_verification_items/new', 'site\User_verification_itemsController@store')->name('user_verification_items_Store');
Route::get('/user_verification_items/edit/{id}', 'site\User_verification_itemsController@edit')->name('user_verification_items_Edit');
Route::get('/user_verification_items/view/{id}', 'site\User_verification_itemsController@view')->name('user_verification_items_Edit');
Route::post('/user_verification_items/edit', 'site\User_verification_itemsController@save')->name('user_verification_items_Save');
Route::get('/user_verification_items/delete/{ids}', 'site\User_verification_itemsController@delete')->name('user_verification_items_Delete');
Route::post('/user_verification_items/deleteattachment', 'site\User_verification_itemsController@deleteattachment')->name('user_verification_items_delete_attachment');

Route::get('/mail_verification/{username}', 'site\User_verification_itemsController@mail_verification')->name('mail_verification');
Route::get('/user/mail_verify/{token}', 'site\User_verification_itemsController@verify_user')->name('mail_verify_user');

//---------> two step verification
Route::get('/twostepenabled/{username}', 'site\TwoStepVerificationController@two_step_enabled')->name('two_step_enabled');
Route::get('/twostepdisabled/{username}', 'site\TwoStepVerificationController@two_step_disabled')->name('two_step_disabled');
Route::get('/user/twostepverify/{token}', 'site\TwoStepVerificationController@two_step_verify')->name('two_step_verify');

//---------> payment
Route::post('/payment', 'site\PaymentController@payment')->name('payment');
Route::get('/payment/cancel', 'site\PaymentController@cancel')->name('payment_cancel');
Route::get('/payment/return', 'site\PaymentController@return')->name('payment_return');

//---------> user_creditcard
Route::get('/user_creditcard/list', 'site\User_creditcardController@list')->name('user_creditcard_List');
Route::get('/user_creditcard/new', 'site\User_creditcardController@new')->name('user_creditcard_New');
Route::post('/user_creditcard/new', 'site\User_creditcardController@store')->name('user_creditcard_Store');
Route::get('/user_creditcard/edit/{id}', 'site\User_creditcardController@edit')->name('user_creditcard_Edit');
Route::get('/user_creditcard/view/{id}', 'site\User_creditcardController@view')->name('user_creditcard_Edit');
Route::post('/user_creditcard/edit', 'site\User_creditcardController@save')->name('user_creditcard_Save');
Route::get('/user_creditcard/delete/{ids}', 'site\User_creditcardController@delete')->name('user_creditcard_Delete');
Route::post('/user_creditcard/deleteattachment', 'site\User_creditcardController@deleteattachment')->name('user_creditcard_delete_attachment');

//---------> chat
Route::get('/chats', 'ChatsController@index');
Route::post('/getmessages', 'ChatsController@fetchMessages');
Route::post('/seemessages', 'ChatsController@seeMessages');
Route::post('/messages', 'ChatsController@sendMessage');
Route::get('/getHistoryUser', 'ChatsController@getHistoryUser');


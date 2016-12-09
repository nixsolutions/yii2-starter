<?php

use yii\db\Migration;

class m161209_135500_add_about_page extends Migration
{
    public function up()
    {
        $this->insert('pages', [
            'key' => 'ABOUT',
            'title' => 'About',
            'content' => '<p>We are glad to represent you our demo Yii2 application.</p>
<p>Yii is a high-performance PHP framework best for developing Web 2.0 applications. Yii comes with rich features: MVC, 
DAO/ActiveRecord, I18N/L10N, caching, authentication and role-based access control, scaffolding, testing, etc. It can 
reduce your development time significantly.</p>
<p>This application has role-based access control. There are three types of users:</p>
<ol>
<li><p>guest - unauthorized user;</p></li>
<li><p>user - registered and logged in user (has access to&nbsp;his profile with ability to update it);</p></li>
<li><p>admin - user which has access to management of this application.</p></li>
</ol>
<p>To create an account here user should fill registration form with personal information and valid email. 
Then he should confirm his registration by following the link which he get on email. After all this user will 
be logged in our application.</p>
<p>If user accidentally forget his password he can recover it by clicking appropriate link on the login page. After 
entering his valid email in password recovery form he should follow instructions that he get on email.</p>
<p>Furthermore, on the login page user can select an option &quot;Remember me&quot;. That provides user an opportunity 
to stay logged in for a week.</p>
<p>Admin has access for users management (he can view user&#39;s data,&nbsp;change&nbsp;status and role) and management 
of templates, which are send to users for registration confirmation, password recovery etc. 
Also admin can manage the content of static pages.</p>',
            'description' => 'Page About',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function down()
    {
        $this->delete('pages', ['key' => 'ABOUT']);
    }
}

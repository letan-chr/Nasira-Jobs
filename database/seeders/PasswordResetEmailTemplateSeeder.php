<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class PasswordResetEmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $emailTemplates = [
            [
                'template_name' => 'Password Reset Email',
                'subject' => 'Reset Password Notification',
                'body' => '<strong style="text-align: left; font-family: Circular Std, sans-serif !important;" class="text-blue-color">
                                Hello!,
                            </strong>
                            <br>
                            <p style="font-family: Circular Std, sans-serif !important;">You are receiving this email because we received a password reset request for your account.</p>
                            <br>
                            <a href="{{reset_url}}" style="display: table; margin: 0 auto; font-family: Circular Std, sans-serif !important;">Reset Password</a>
                            <br>
                            <p style="font-family: Circular Std, sans-serif !important;">This password reset link will expire in 60 minutes.</p><br>
                            <p style="font-family: Circular Std, sans-serif !important;">If you did not request a password reset, no further action is required.</p><br>
                            <strong style="display: block; margin-top: 15px; font-family: Circular Std, sans-serif !important;" class="text-blue-color">Regards,<br>
                                {{from_name}}
                            </strong>
                            ',
                'variables' => '{{reset_url}},{{from_name}}',
            ],
        ];

        foreach ($emailTemplates as $emailTemplate) {
            $template_name = EmailTemplate::where('template_name', $emailTemplate['template_name'])->first();

            if (isset($template_name)) {
                $template_name->update($emailTemplate);
            } else {
                EmailTemplate::create($emailTemplate);
            }
        }
    }

}

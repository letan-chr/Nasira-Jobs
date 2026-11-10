<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

/**
 * Class EmailTemplateSeeder
 */
class EmailTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $emailTemplates = [
            [
                'template_name' => 'Job Notification',
                'subject' => 'New Job Notification',
                'body' => '<strong style="text-align: left;" class="text-blue-color">
                               Hi {{candidate_name}},
                            </strong>
                            <br/><br>
                            Notification of all Job opportunities updated on {{date}} in <a target="_blank" href="{{app_url}}">{{from_name}}</a>
                            <br/><br>
                            {{jobs}}
                            <strong style="display: block; margin-top: 15px;" class="text-blue-color">Regards, <br/>
                                {{from_name}}
                            </strong>',
                'variables' => '{{candidate_name}}, {{app_url}}, {{from_name}}',
            ],
            [
                'template_name' => 'Contact Us',
                'subject' => 'Thanks For Contacting',
                'body' => ' <strong style="text-align: left;" class="text-blue-color">
                                Hello! {{name}},
                            </strong>
                            <br/><br>
                            Thanks for contacting us.
                            <br/><br>
                            Quaerat facere dicta<br/><br>
                            Apart from the email, you can also contact me on my cell : {{phone_no}}<br><br>
                            <strong style="display: block; margin-top: 15px;" class="text-blue-color">Regards, <br/>
                                {{from_name}}
                            </strong>',
                'variables' => '{{name}}, {{phone_no}}, {{from_name}}',
            ],
            [
                'template_name' => 'News Letter',
                'subject' => '',
                'body' => '<strong style="text-align: left;" class="text-blue-color">
                                Hello Dear,
                            </strong>
                            <br/><br>
                            New Notice from {{from_name}}. <br/><br>
                            {{description}}<br><br>
                            <strong style="display: block; margin-top: 15px;" class="text-blue-color">Regards, <br/>
                                {{from_name}}
                            </strong>',
                'variables' => '{{description}}, {{from_name}}',
            ],
            [
                'template_name' => 'Email Job To Friend',
                'subject' => 'Email for Job Details',
                'body' => ' <strong style="text-align: left;" class="text-blue-color">
                                Hi {{friend_name}},
                            </strong>
                            <br/><br>
                            I have send you the below job link in which you can find the relevant details for the same.
                            <br/><br>
                                Link : <a href="{{job_url}}" target="_blank">{{job_url}}</a>
                            <br><br>
                            <strong style="display: block; margin-top: 15px;" class="text-blue-color">Regards, <br/>
                                {{from_name}}
                            </strong>',
                'variables' => '{{friend_name}}, {{job_url}}, {{from_name}}',
            ],
            [
                'template_name' => 'Job Alert',
                'subject' => 'New Job Alert',
                'body' => '<strong style="text-align: left;" class="text-blue-color">
                               Hi {{job_name}},
                            </strong>
                            <br/><br>
                            <h2>Job Title: {{job_title}}</h2>
                            <br/><br>
                            New job posted with {{job_title}}, if you are interested then you can apply for this job.<br><br><br>
                            <a href="{{job_url}}" target="_blank" style="display: table; margin: 0 auto;">View Job</a>
                            <br><br>
                            <strong style="display: block; margin-top: 15px;" class="text-blue-color">Thanks, <br/>
                                {{from_name}}
                            </strong>',
                'variables' => '{{job_name}},{{job_url}}, {{job_title}}, {{from_name}}',
            ],
            [
                'template_name' => 'Candidate Job Applied',
                'subject' => 'Job Applied by Candidate',
                'body' => '<strong style="text-align: left;" class="text-blue-color">
                                Hi {{employer_fullName}},
                            </strong>
                            <br/><br>
                            <h2>Someone just applied for job : {{job_title}}</h2>
                            <br/><br>
                            My name is {{candidate_name}}<br><br>
                            I have go through with your job details and thereby i have applied for the same. Please kindly contact me if i found suitable based on your needs.<br><br><br>
                            <a href="{{candidate_details_url}}" target="_blank" style="display: table; margin: 0 auto;">View Candidate Profile</a>
                            <br><br>
                            <strong style="display: block; margin-top: 15px;" class="text-blue-color">Regards, <br/>
                                {{from_name}}
                            </strong>',
                'variables' => '{{employer_fullName}},{{candidate_name}},{{candidate_details_url}}, {{job_title}}, {{from_name}}',
            ],
            [
                'template_name' => 'Verify Email',
                'subject' => 'Verify Email Address',
                'body' => '<strong style="text-align: left;" class="text-blue-color">
                                Hello! {{user_name}},
                            </strong>
                            <br/><br>
                            Please click the button below to verify your email address.
                            <br/><br><br>
                                <a href="{{verify_url}}" style="display: table; margin: 0 auto;">Verify Email Address</a>
                            <br><br>
                            If you did not create an account, no further action is required.<br><br>
                            <strong style="display: block; margin-top: 15px;" class="text-blue-color">Regards, <br/>
                                {{from_name}}
                            </strong>',
                'variables' => '{{user_name}},{{verify_url}},{{from_name}}',
            ],
            [
                'template_name' => 'Password Reset Email',
                'subject' => 'Reset Password Notification',
                'body' => '<strong style="text-align: left;" class="text-blue-color">
                                Hello!,
                            </strong>
                            <br/><br>
                            You are receiving this email because we received a password reset request for your account.
                            <br/><br><br>
                            <a href="{{reset_url}}" style="display: table; margin: 0 auto;">Reset Password</a>
                            <br><br>
                            This password reset link will expire in 60 minutes.<br><br>
                            If you did not request a password reset, no further action is required.<br><br>
                            <strong style="display: block; margin-top: 15px;" class="text-blue-color">Regards, <br/>
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

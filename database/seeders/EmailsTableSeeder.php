<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EmailsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('emails')->delete();
        
        \DB::table('emails')->insert(array (
            0 => 
            array (
                'id' => 1,
                'type' => 'resetPassword',
                'description' => 'Configure e-mail message that is sent to recover the forgotten password',
                'subject' => 'Reset your password',
                'content' => '<p>Dear {{name}},</p>
<p>Please <a href="{{resetLink}}">click here</a> to reset your password.</p>
<p>If you are not able to click on link please copy and paste: {{resetLink}} in your browser.</p>
<p>Regards,</p>
<p>Team AI Engine.</p>',
                'created_at' => NULL,
                'updated_at' => '2023-02-17 07:50:14',
            ),
            1 => 
            array (
                'id' => 2,
                'type' => 'verifyAccount',
                'description' => 'Configure e-mail message that is sent to activate your account',
                'subject' => '{{name}}! Verify your account',
                'content' => '<div>Dear {{name}},</div>
<div>&nbsp;</div>
<div>You&rsquo;re almost there. Confirm your account below to finish creating your account.</div>
<div>Please&nbsp;<a href="{{validationLink}}" data-name="Apple Music Toolbox" data-type="url">click here</a>&nbsp;to confirm your account.</div>
<div>&nbsp;</div>
<div>If you are not able to click on link please copy and paste: {{validationLink}} in your browser.</div>
<div>&nbsp;</div>
<div>Regards,</div>
<div>Team AI Engine.</div>',
                'created_at' => NULL,
                'updated_at' => '2023-02-17 07:49:33',
            ),
            2 => 
            array (
                'id' => 3,
                'type' => 'newUser',
                'description' => 'Configure e-mail message that is sent to welcome new user',
                'subject' => 'Welcome, We\'re so Glad You\'re Here',
                'content' => '<p>{{name}}, Welcome to AI Engine</p>
<p>Use AI to boost your traffic and save hours of work. Automatically write unique, engaging and high-quality copy or content: from long-form blog posts or landing pages to digital ads in seconds.</p>
<p>Regards,</p>
<p>Team AI Engine.</p>',
                'created_at' => NULL,
                'updated_at' => '2023-02-17 07:50:04',
            ),
            3 => 
            array (
                'id' => 14,
                'type' => 'subscriptionReceipt',
                'description' => 'Configure e-mail message that is sent when a subscription has been placed.',
                'subject' => 'Your receipt from ‪‬ #{{receipt_id}}',
                'content' => '<div style="margin: 0; padding: 0; border: 0; background-color: #f1f5f9; font-family: -apple-system,BlinkMacSystemFont,\'Segoe UI\',Roboto,\'Helvetica Neue\',Ubuntu,sans-serif; min-width: 100%!important; width: 100%!important;">
<div style="display: none!important; max-height: 0; max-width: 0; overflow: hidden; color: #ffffff; font-size: 1px; line-height: 1px; opacity: 0;">&nbsp;</div>
<div style="min-width: 100%; width: 100%; background-color: #f1f5f9;">
<table class="m_-8504956366380948631Wrapper" style="border: 0; border-collapse: collapse; margin: 0 auto!important; padding: 0; max-width: 600px; min-width: 600px; width: 600px;" align="center">
<tbody>
<tr>
<td style="border: 0; border-collapse: collapse; margin: 0; padding: 0;">
<table class="m_-8504956366380948631Divider--kill" style="border: 0; border-collapse: collapse; margin: 0; padding: 0;" width="100%">
<tbody>
<tr>
<td style="border: 0; border-collapse: collapse; margin: 0; padding: 0; color: #ffffff; font-size: 1px; line-height: 1px;" height="20">&nbsp;</td>
</tr>
</tbody>
</table>
<div style="border-bottom-left-radius: 5px; border-bottom-right-radius: 5px;">
<table class="m_-8504956366380948631Section m_-8504956366380948631Header" dir="ltr" style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; background-color: #ffffff; width: 100%;" width="100%">
<tbody>
<tr>
<td class="m_-8504956366380948631Header-left m_-8504956366380948631Target" style="background-color: #e23136; border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; font-size: 30px; line-height: 156px; background-size: 100% 100%; border-top-left-radius: 5px; color: white; text-align: center;" align="right" valign="bottom" width="100%" height="156">AI Engine</td>
</tr>
</tbody>
</table>
<table class="m_-8504956366380948631Section" style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; background-color: #ffffff; height: 59px; width: 100%;" width="100%">
<tbody>
<tr style="height: 59px;">
<td class="m_-8504956366380948631Spacer--gutter" style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 59px;" width="64">&nbsp;</td>
<td class="m_-8504956366380948631Content" style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; width: 472px; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Ubuntu, sans-serif; vertical-align: middle; color: #32325d; font-size: 24px; line-height: 32px; height: 59px;" align="center">Receipt from</td>
<td class="m_-8504956366380948631Spacer--gutter" style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 59px;" width="64">&nbsp;</td>
</tr>
</tbody>
</table>
<table class="m_-8504956366380948631Section" style="border: 0; border-collapse: collapse; margin: 0; padding: 0; background-color: #ffffff;" width="100%">
<tbody>
<tr>
<td style="border: 0; border-collapse: collapse; margin: 0; padding: 0; color: #ffffff; font-size: 1px; line-height: 1px;" height="8">&nbsp;</td>
</tr>
</tbody>
</table>
<table class="m_-8504956366380948631Section" style="border: 0; border-collapse: collapse; margin: 0; padding: 0; background-color: #ffffff;" width="100%">
<tbody>
<tr>
<td class="m_-8504956366380948631Spacer--gutter" style="border: 0; border-collapse: collapse; margin: 0; padding: 0; color: #ffffff; font-size: 1px; line-height: 1px;" width="64">&nbsp;</td>
<td class="m_-8504956366380948631Content" style="border: 0; border-collapse: collapse; margin: 0; padding: 0; width: 472px; font-family: -apple-system,BlinkMacSystemFont,\'Segoe UI\',Roboto,\'Helvetica Neue\',Ubuntu,sans-serif; vertical-align: middle; color: #8898aa; font-size: 15px; line-height: 18px;" align="center"><span class="il">Invoice</span> #{{invoice_id}}</td>
<td class="m_-8504956366380948631Spacer--gutter" style="border: 0; border-collapse: collapse; margin: 0; padding: 0; color: #ffffff; font-size: 1px; line-height: 1px;" width="64">&nbsp;</td>
</tr>
</tbody>
</table>
<table class="m_-8504956366380948631Section" style="border: 0; border-collapse: collapse; margin: 0; padding: 0; background-color: #ffffff;" width="100%">
<tbody>
<tr>
<td style="border: 0; border-collapse: collapse; margin: 0; padding: 0; color: #ffffff; font-size: 1px; line-height: 1px;" height="4">&nbsp;</td>
</tr>
</tbody>
</table>
<table class="m_-8504956366380948631Section" style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; background-color: #ffffff; height: 18px; width: 100%;" width="100%">
<tbody>
<tr style="height: 18px;">
<td class="m_-8504956366380948631Spacer--gutter" style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 18px;" width="64">&nbsp;</td>
<td class="m_-8504956366380948631Content" style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; width: 472px; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Ubuntu, sans-serif; vertical-align: middle; color: #8898aa; font-size: 15px; line-height: 18px; height: 18px;" align="center">Receipt #{{receipt_id}}</td>
<td class="m_-8504956366380948631Spacer--gutter" style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 18px;" width="64">&nbsp;</td>
</tr>
</tbody>
</table>
<table class="m_-8504956366380948631Section" style="border: 0; border-collapse: collapse; margin: 0; padding: 0; background-color: #ffffff;" width="100%">
<tbody>
<tr>
<td style="border: 0; border-collapse: collapse; margin: 0; padding: 0; color: #ffffff; font-size: 1px; line-height: 1px;" height="24">&nbsp;</td>
</tr>
</tbody>
</table>
<table class="m_-8504956366380948631Section" style="border: 0; border-collapse: collapse; margin: 0; padding: 0; background-color: #ffffff; width: 100%;" width="100%">
<tbody>
<tr>
<td class="m_-8504956366380948631Spacer--gutter" style="border: 0; border-collapse: collapse; margin: 0; padding: 0; color: #ffffff; font-size: 1px; line-height: 1px;" width="64">&nbsp;</td>
<td class="m_-8504956366380948631Content" style="border: 0; border-collapse: collapse; margin: 0; padding: 0; width: 472px;">
<table style="border: 0; border-collapse: collapse; margin: 0; padding: 0; width: 100%;">
<tbody>
<tr>
<td class="m_-8504956366380948631DataBlocks-item" style="border: 0; border-collapse: collapse; margin: 0; padding: 0;" valign="top">
<table style="border: 0; border-collapse: collapse; margin: 0; padding: 0;">
<tbody>
<tr>
<td style="border: 0; border-collapse: collapse; margin: 0; padding: 0; font-family: -apple-system,BlinkMacSystemFont,\'Segoe UI\',Roboto,\'Helvetica Neue\',Ubuntu,sans-serif; vertical-align: middle; color: #8898aa; font-size: 12px; line-height: 16px; white-space: nowrap; font-weight: bold; text-transform: uppercase;">Amount paid</td>
</tr>
<tr>
<td style="border: 0; border-collapse: collapse; margin: 0; padding: 0; font-family: -apple-system,BlinkMacSystemFont,\'Segoe UI\',Roboto,\'Helvetica Neue\',Ubuntu,sans-serif; vertical-align: middle; color: #525f7f; font-size: 15px; line-height: 24px; white-space: nowrap;">{{currency}}{{amount}}</td>
</tr>
</tbody>
</table>
</td>
<td class="m_-8504956366380948631DataBlocks-spacer" style="border: 0; border-collapse: collapse; margin: 0; padding: 0; color: #ffffff; font-size: 1px; line-height: 1px;" width="20">&nbsp;</td>
<td class="m_-8504956366380948631DataBlocks-item" style="border: 0; border-collapse: collapse; margin: 0; padding: 0;" valign="top">
<table style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; width: 94px;">
<tbody>
<tr>
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Ubuntu, sans-serif; vertical-align: middle; color: #8898aa; font-size: 12px; line-height: 16px; white-space: nowrap; font-weight: bold; text-transform: uppercase; width: 94px;">Date paid</td>
</tr>
<tr>
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Ubuntu, sans-serif; vertical-align: middle; color: #525f7f; font-size: 15px; line-height: 24px; white-space: nowrap; width: 94px;">{{issued_date}}</td>
</tr>
</tbody>
</table>
</td>
<td class="m_-8504956366380948631DataBlocks-spacer" style="border: 0; border-collapse: collapse; margin: 0; padding: 0; color: #ffffff; font-size: 1px; line-height: 1px;" width="20">&nbsp;</td>
<td class="m_-8504956366380948631DataBlocks-item" style="border: 0; border-collapse: collapse; margin: 0; padding: 0;" valign="top">
<table style="border: 0; border-collapse: collapse; margin: 0; padding: 0;">
<tbody>
<tr>
<td style="border: 0; border-collapse: collapse; margin: 0; padding: 0; font-family: -apple-system,BlinkMacSystemFont,\'Segoe UI\',Roboto,\'Helvetica Neue\',Ubuntu,sans-serif; vertical-align: middle; color: #8898aa; font-size: 12px; line-height: 16px; white-space: nowrap; font-weight: bold; text-transform: uppercase;">Payment method</td>
</tr>
<tr>
<td style="border: 0; border-collapse: collapse; margin: 0; padding: 0; font-family: -apple-system,BlinkMacSystemFont,\'Segoe UI\',Roboto,\'Helvetica Neue\',Ubuntu,sans-serif; vertical-align: middle; color: #525f7f; font-size: 15px; line-height: 24px; white-space: nowrap;">{{payment_gate}}</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
<td class="m_-8504956366380948631Spacer--gutter" style="border: 0; border-collapse: collapse; margin: 0; padding: 0; color: #ffffff; font-size: 1px; line-height: 1px;" width="64">&nbsp;</td>
</tr>
</tbody>
</table>
<table class="m_-8504956366380948631Section" style="border: 0; border-collapse: collapse; margin: 0; padding: 0; background-color: #ffffff;" width="100%">
<tbody>
<tr>
<td style="border: 0; border-collapse: collapse; margin: 0; padding: 0; color: #ffffff; font-size: 1px; line-height: 1px;" height="32">&nbsp;</td>
</tr>
</tbody>
</table>
<table class="m_-8504956366380948631Section" style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; background-color: #ffffff; height: 28px;">
<tbody>
<tr style="height: 16px;">
<td class="m_-8504956366380948631Spacer--gutter" style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 16px; width: 64px;">&nbsp;</td>
<td class="m_-8504956366380948631Content" style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; width: 472px; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Ubuntu, sans-serif; vertical-align: middle; color: #8898aa; font-size: 12px; line-height: 16px; font-weight: bold; text-transform: uppercase; height: 16px;">Summary</td>
<td class="m_-8504956366380948631Spacer--gutter" style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 16px; width: 64px;">&nbsp;</td>
</tr>
<tr style="height: 12px;">
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 12px; width: 600px;" colspan="3" height="12">&nbsp;</td>
</tr>
</tbody>
</table>
<table class="m_-8504956366380948631Section" style="border: 0; border-collapse: collapse; margin: 0; padding: 0; background-color: #ffffff;" width="100%">
<tbody>
<tr>
<td class="m_-8504956366380948631Spacer--kill" style="border: 0; border-collapse: collapse; margin: 0; padding: 0; color: #ffffff; font-size: 1px; line-height: 1px;" width="64">&nbsp;</td>
<td class="m_-8504956366380948631Content" style="border: 0; border-collapse: collapse; margin: 0; padding: 0; width: 472px;">
<table style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; width: 100%; background-color: #f6f9fc; border-radius: 4px; height: 345px;">
<tbody>
<tr style="height: 4px;">
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 4px;" colspan="3" height="4">&nbsp;</td>
</tr>
<tr style="height: 331px;">
<td class="m_-8504956366380948631Spacer--gutter" style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 331px;" width="20">&nbsp;</td>
<td class="m_-8504956366380948631Table-content" style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; width: 432px; height: 331px;">
<table class="m_-8504956366380948631Table-rows" style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; height: 339px;" width="432">
<tbody>
<tr style="height: 6px;">
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 6px; width: 432px;" colspan="3" height="6">&nbsp;</td>
</tr>
<tr style="height: 6px;">
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 6px; width: 432px;" colspan="3" height="6">&nbsp;</td>
</tr>
<tr style="height: 16px;">
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Ubuntu, sans-serif; vertical-align: middle; color: #8898aa; font-size: 12px; line-height: 16px; font-weight: bold; text-transform: uppercase; height: 16px; width: 367px;">{{issued_date}} &ndash; {{next_billing}}</td>
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 16px; width: 8px;">&nbsp;</td>
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 16px; width: 57px;">&nbsp;</td>
</tr>
<tr style="height: 10px;">
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 10px; width: 432px;" colspan="3" height="6">&nbsp;</td>
</tr>
<tr style="height: 6px;">
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 6px; width: 432px;" colspan="3" height="6">&nbsp;</td>
</tr>
<tr style="height: 6px;">
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 6px; width: 432px;" colspan="3" height="6">&nbsp;</td>
</tr>
<tr style="height: 24px;">
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Ubuntu, sans-serif; vertical-align: middle; color: #525f7f; font-size: 15px; line-height: 24px; word-break: break-word; height: 24px; width: 367px;">{{plan}} {{currency}}{{plan_price}} / {{plan_frequency}}&nbsp;<span class="m_-8504956366380948631Content" style="border: 0; border-collapse: collapse; margin: 0; padding: 0; font-family: -apple-system,BlinkMacSystemFont,\'Segoe UI\',Roboto,\'Helvetica Neue\',Ubuntu,sans-serif; color: #8898aa; font-size: 14px; line-height: 14px;"> &times; 1</span></td>
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 24px; width: 8px;">&nbsp;</td>
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Ubuntu, sans-serif; vertical-align: middle; color: #525f7f; font-size: 15px; line-height: 24px; height: 24px; width: 57px;" align="right" valign="top">{{currency}}{{amount}}</td>
</tr>
<tr style="height: 6px;">
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 6px; width: 432px;" colspan="3" height="6">&nbsp;</td>
</tr>
<tr style="height: 10px;">
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 10px; width: 432px;" colspan="3" height="6">&nbsp;</td>
</tr>
<tr style="height: 6px;">
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 6px; width: 432px;" colspan="3" height="6">&nbsp;</td>
</tr>
<tr style="height: 1px;">
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 1px; width: 432px;" colspan="3" bgcolor="e6ebf1" height="1">&nbsp;</td>
</tr>
<tr style="height: 6px;">
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 6px; width: 432px;" colspan="3" height="6">&nbsp;</td>
</tr>
<tr style="height: 6px;">
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 6px; width: 432px;" colspan="3" height="6">&nbsp;</td>
</tr>
<tr style="height: 24px;">
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Ubuntu, sans-serif; vertical-align: middle; color: #525f7f; font-size: 15px; line-height: 24px; font-weight: 500; height: 24px; width: 367px;">Subtotal</td>
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 24px; width: 8px;">&nbsp;</td>
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Ubuntu, sans-serif; vertical-align: middle; color: #525f7f; font-size: 15px; line-height: 24px; font-weight: 500; height: 24px; width: 57px;" align="right" valign="top">{{currency}}{{amount}}</td>
</tr>
<tr style="height: 6px;">
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 6px; width: 432px;" colspan="3" height="6">&nbsp;</td>
</tr>
<tr style="height: 6px;">
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 6px; width: 432px;" colspan="3" height="6">&nbsp;</td>
</tr>
<tr style="height: 24px;">
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Ubuntu, sans-serif; vertical-align: middle; color: #525f7f; font-size: 15px; line-height: 24px; font-weight: bold; height: 24px; width: 367px;">Amount paid</td>
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 24px; width: 8px;">&nbsp;</td>
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Ubuntu, sans-serif; vertical-align: middle; color: #525f7f; font-size: 15px; line-height: 24px; font-weight: bold; height: 24px; width: 57px;" align="right" valign="top">{{currency}}{{amount}}</td>
</tr>
<tr style="height: 6px;">
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 6px; width: 432px;" colspan="3" height="6">&nbsp;</td>
</tr>
<tr style="height: 6px;">
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 6px; width: 432px;" colspan="3" height="6">&nbsp;</td>
</tr>
<tr style="height: 1px;">
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 1px; width: 432px;" colspan="3" bgcolor="e6ebf1" height="1">&nbsp;</td>
</tr>
<tr style="height: 6px;">
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 6px; width: 432px;" colspan="3" height="6">&nbsp;</td>
</tr>
<tr style="height: 6px;">
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 6px; width: 432px;" colspan="3" height="6">&nbsp;</td>
</tr>
<tr style="height: 6px;">
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 6px; width: 432px;" colspan="3" height="6">&nbsp;</td>
</tr>
<tr style="height: 6px;">
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 6px; width: 432px;" colspan="3" height="6">&nbsp;</td>
</tr>
<tr style="height: 6px;">
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 6px; width: 432px;" colspan="3" height="6">&nbsp;</td>
</tr>
</tbody>
</table>
</td>
<td class="m_-8504956366380948631Spacer--gutter" style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 331px;" width="20">&nbsp;</td>
</tr>
<tr style="height: 10px;">
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 10px;" colspan="3" height="4">&nbsp;</td>
</tr>
</tbody>
</table>
</td>
<td class="m_-8504956366380948631Spacer--kill" style="border: 0; border-collapse: collapse; margin: 0; padding: 0; color: #ffffff; font-size: 1px; line-height: 1px;" width="64">&nbsp;</td>
</tr>
</tbody>
</table>
<table class="m_-8504956366380948631Section" style="border: 0; border-collapse: collapse; margin: 0; padding: 0; background-color: #ffffff;" width="100%">
<tbody>
<tr>
<td style="border: 0; border-collapse: collapse; margin: 0; padding: 0; color: #ffffff; font-size: 1px; line-height: 1px;" height="44">&nbsp;</td>
</tr>
</tbody>
</table>
<table class="m_-8504956366380948631Section" style="border: 0; border-collapse: collapse; margin: 0; padding: 0; background-color: #ffffff;" width="100%">
<tbody>
<tr>
<td class="m_-8504956366380948631Spacer--gutter" style="border: 0; border-collapse: collapse; margin: 0; padding: 0; color: #ffffff; font-size: 1px; line-height: 1px;" width="64">&nbsp;</td>
<td style="border: 0; border-collapse: collapse; margin: 0; padding: 0; color: #ffffff; font-size: 1px; line-height: 1px;" bgcolor="e6ebf1" height="1">&nbsp;</td>
<td class="m_-8504956366380948631Spacer--gutter" style="border: 0; border-collapse: collapse; margin: 0; padding: 0; color: #ffffff; font-size: 1px; line-height: 1px;" width="64">&nbsp;</td>
</tr>
</tbody>
</table>
<table class="m_-8504956366380948631Section" style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; background-color: #ffffff; height: 32px; width: 100%;" width="100%">
<tbody>
<tr style="height: 32px;">
<td style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 32px;" height="32">&nbsp;</td>
</tr>
</tbody>
</table>
<table class="m_-8504956366380948631Section" style="border: 0; border-collapse: collapse; margin: 0; padding: 0; background-color: #ffffff;" width="100%">
<tbody>
<tr>
<td style="border: 0; border-collapse: collapse; margin: 0; padding: 0; color: #ffffff; font-size: 1px; line-height: 1px;" height="20">&nbsp;</td>
</tr>
</tbody>
</table>
<table class="m_-8504956366380948631Section" style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; background-color: #ffffff; height: 16px;">
<tbody>
<tr style="height: 16px;">
<td class="m_-8504956366380948631Spacer--gutter" style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 16px; width: 64px;">&nbsp;</td>
<td class="m_-8504956366380948631Content" style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; width: 472px; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Ubuntu, sans-serif; vertical-align: middle; color: #8898aa; font-size: 12px; line-height: 16px; height: 16px;">If you have any questions, please send an email to <a href="mailto:ninacoder2510@gmail.com">ninacoder2510@gmail.com</a>. We\'ll get back to you as soon as we can.</td>
<td class="m_-8504956366380948631Spacer--gutter" style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; color: #ffffff; font-size: 1px; line-height: 1px; height: 16px; width: 64px;">&nbsp;</td>
</tr>
</tbody>
</table>
<table class="m_-8504956366380948631Section" style="border: 0; border-collapse: collapse; margin: 0; padding: 0; background-color: #ffffff;">
<tbody>
<tr>
<td class="m_-8504956366380948631Spacer--gutter" style="border: 0; border-collapse: collapse; margin: 0; padding: 0; color: #ffffff; font-size: 1px; line-height: 1px;" width="64">&nbsp;</td>
<td class="m_-8504956366380948631Content" style="border: 0; border-collapse: collapse; margin: 0; padding: 0; width: 472px; font-family: -apple-system,BlinkMacSystemFont,\'Segoe UI\',Roboto,\'Helvetica Neue\',Ubuntu,sans-serif; vertical-align: middle; color: #8898aa; font-size: 12px; line-height: 16px;">You\'re receiving this email because you made a purchase for a subscription plan on AI Engine.</td>
<td class="m_-8504956366380948631Spacer--gutter" style="border: 0; border-collapse: collapse; margin: 0; padding: 0; color: #ffffff; font-size: 1px; line-height: 1px;" width="64">&nbsp;</td>
</tr>
</tbody>
</table>
<table class="m_-8504956366380948631Section m_-8504956366380948631Section--last" style="border: 0; border-collapse: collapse; margin: 0; padding: 0; background-color: #ffffff; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px;" width="100%">
<tbody>
<tr>
<td style="border: 0; border-collapse: collapse; margin: 0; padding: 0; color: #ffffff; font-size: 1px; line-height: 1px;" height="64">&nbsp;</td>
</tr>
</tbody>
</table>
</div>
</td>
</tr>
</tbody>
</table>
</div>
<table class="m_-8504956366380948631Divider--kill" style="border: 0; border-collapse: collapse; margin: 0; padding: 0;" width="100%">
<tbody>
<tr>
<td style="border: 0; border-collapse: collapse; margin: 0; padding: 0; color: #ffffff; font-size: 1px; line-height: 1px;" height="20">&nbsp;</td>
</tr>
</tbody>
</table>
<div class="yj6qo">&nbsp;</div>
<div class="adL">&nbsp;</div>
</div>',
                'created_at' => NULL,
                'updated_at' => '2023-02-17 07:49:16',
            ),
        ));
        
        
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: ABarmin
 * Date: 24.11.2014
 * Time: 14:34
 */

$s_status_enum_string = '10:new,20:feedback,30:acknowledged,40:confirmed,50:assigned,80:resolved,90:closed,60:assessment,61:review,62:allocation,63:execution';
$s_status_enum_string .= ',64:qualification';
$s_status_enum_string .= ',65:testing';
$s_status_enum_string .= ',66:completed';

$s_assessment_bug_title = 'Mark issue for ASSESSMENT';
$s_assessment_bug_button = 'ASSESSMENT';

$s_email_notification_title_for_status_bug_assessment = 'Баг готов к оценке';
$s_email_notification_title_for_status_bug_review = 'Баг готов к согласованию';
$s_email_notification_title_for_status_bug_allocation = 'Баг готов к распределению';
$s_email_notification_title_for_status_bug_execution = 'Баг готов к исполнению';
$s_email_notification_title_for_status_bug_qualification = 'Баг готов к уточнению';
$s_email_notification_title_for_status_bug_testing = 'Баг готов к тестированию';
$s_email_notification_title_for_status_bug_completed = 'Работа по багу завершена';

if (lang_get_current() == 'russian') {
    $s_status_enum_string = '10:новый,20:нужен отклик,30:рассмотрен,40:подтвержден,50:назначен,80:отработан,90:закрыт,60:оценка,61:согласование,62:распределение';
    $s_status_enum_string .= ',63:исполнение';
    $s_status_enum_string .= ',64:уточнение';
    $s_status_enum_string .= ',65:тестирование';
    $s_status_enum_string .= ',66:выполнено';

    $s_assessment_bug_title = 'Отправить на оценку';
    $s_assessment_bug_button = 'Отправить на оценку';

    $s_review_bug_title = 'Отправить на согласование';
    $s_review_bug_button = 'Отправить на согласование';

    $s_allocation_bug_title = 'Отправить на распределение';
    $s_allocation_bug_button = 'Отправить на распределение';

    $s_execution_bug_title = 'Отправить на исполнение';
    $s_execution_bug_button = 'Отправить на исполнение';

    $s_qualification_bug_title = 'Отправить на уточнение';
    $s_qualification_bug_button = 'Отправить на уточнение';

    $s_testing_bug_title = 'Отправить на тестирование';
    $s_testing_bug_button = 'Отправить на тестирование';

    $s_completed_bug_title = 'Работа по багу завершена';
    $s_completed_bug_button = 'Работа по багу завершена';

    $s_email_notification_title_for_status_bug_assessment = 'Баг готов к оценке';
    $s_email_notification_title_for_status_bug_review = 'Баг готов к согласованию';
    $s_email_notification_title_for_status_bug_allocation = 'Баг готов к распределению';
    $s_email_notification_title_for_status_bug_execution = 'Баг готов к исполнению';
    $s_email_notification_title_for_status_bug_qualification = 'Баг готов к уточнению';
    $s_email_notification_title_for_status_bug_testing = 'Баг готов к тестированию';
    $s_email_notification_title_for_status_bug_completed = 'Работа по багу завершена';
}

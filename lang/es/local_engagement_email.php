<?php
// This file is part of the Local Engagement Email plugin
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This plugin sends users emails based on triggered events:
 * Account creation, Course creation, Enrollment in a course and Course completion.
 * Emails can be enabled/disabled, configured and support multi language.
 * 
 * Credits to Bas Brands, basbrands.nl, bas@sonsbeekmedia.nl
 * for the inspiration and the use of his code as base to develop this plugin.
 *
 * @package    local
 * @subpackage engagement_email
 * @copyright  2024 Josemaria Bolanos <josemabol@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 $string['pluginname'] = 'Correos de compromiso';

$string['manageemails'] = 'Gestionar correos';

// Configuraciones
$string['engagement_email_enabled'] = 'Habilitar correos de compromiso';
$string['engagement_email_enabled_desc'] = 'Habilitar el envío de correos de compromiso personalizados basados en eventos';
$string['senderaddress'] = 'Cuenta del remitente';
$string['senderaddress_desc'] = 'Cuenta a utilizar como remitente para los correos de compromiso';

// Gestión
$string['available_emails_header'] = 'Correos de compromiso disponibles';
$string['resetfilters'] = 'Restablecer filtros';
$string['eventname'] = 'Nombre del evento';
$string['test'] = 'Prueba';

// Eventos soportados
$string['user_created'] = 'Usuario creado';
$string['course_created'] = 'Curso creado';
$string['user_enrolment_created'] = 'Inscripción de usuario creada';
$string['course_completed'] = 'Curso completado';

// Manejadores de mensajes
$string['messageprovider:user_created'] = 'Usuario creado';
$string['messageprovider:course_created'] = 'Curso creado';
$string['messageprovider:user_enrolment_created'] = 'Inscripción de usuario creada';
$string['messageprovider:course_completed'] = 'Curso completado';

// Cancelar suscripción a notificaciones por correo
$string['unsubscribe:email'] = 'Notificaciones por correo';
$string['profile:subscribe'] = 'Suscribirse a todos los correos';
$string['profile:unsubscribe'] = 'Cancelar suscripción a todos los correos';
$string['confirm:subscribe'] = '¿Suscribirse a todas las notificaciones por correo?';
$string['confirm:unsubscribe'] = '¿Está seguro de que desea cancelar la suscripción a todas las notificaciones por correo?';
$string['subscribe'] = 'Suscrito a todas las notificaciones por correo';
$string['unsubscribe'] = 'Cancelada la suscripción a todas las notificaciones por correo';
$string['error:subscribe'] = 'Error al suscribirse a las notificaciones por correo';
$string['error:unsubscribe'] = 'Error al cancelar la suscripción a las notificaciones por correo';

// Plantillas predeterminadas
$string['user_created:emailsubject'] = '¡Bienvenido a [[sitename]]!';
$string['user_created:emailbody'] = '<p>Estimado [[user:fullname]],</p>
<p>Bienvenido a nuestra plataforma de aprendizaje [[sitelink]].</p>
<p>Ahora puedes crear cursos con IA. ¡Crea tu primer curso ahora! [[adv:coursecreatelink]]</p>
<p>También puedes inscribirte en cursos de otros creadores, puedes ver el catálogo <a href="[[coursecatalogurl]]">aquí</a>.</p>';
$string['course_created:emailsubject'] = '¡Curso creado!';
$string['course_created:emailbody'] = '<p>Estimado [[user:fullname]],</p>
<p>Bien hecho, has creado un nuevo curso llamado [[course:fullname]].</p>
<p>¡Tu curso está listo! Puedes acceder a él <a href="[[course:url]]">aquí</a>.</p>
<p>Compártelo con tus amigos/estudiantes: [[adv:coursesharelink]]</p>
<p>Crea otro curso aquí: [[adv:coursecreatelink]]</p>';
$string['user_enrolment_created:emailsubject'] = 'Ahora estás inscrito en [[course:fullname]]';
$string['user_enrolment_created:emailbody'] = '<p>Estimado [[user:fullname]],</p>
<p>Ahora estás inscrito en el curso [[course:fullname]].</p>
<p>Invita a tus amigos a unirse: [[adv:coursesharelink]]</p>
<p>También puedes crear tus propios cursos con IA: [[adv:coursecreatelink]]</p>
<p>¡Disfruta tu curso en [[sitelink]]!</p>';
$string['course_completed:emailsubject'] = '¡Has completado el curso [[course:fullname]]!';
$string['course_completed:emailbody'] = '<p>Estimado [[user:fullname]],</p>
<p>Has completado con éxito el curso [[course:fullname]].</p>
<p>[[adv:certificate_cta]]</p>
<p>Si disfrutaste este curso, compártelo con tus amigos: [[adv:coursesharelink]]</p>
<p>Puedes crear tus propios cursos con IA: [[adv:coursecreatelink]]</p>
<p>Y registrarte en más cursos, puedes ver el catálogo <a href="[[coursecatalogurl]]">aquí</a>.</p>';
$string['get_certificate'] = '<p>Obtén tu certificado <a href="{$a}">aquí</a>.</p>';

// Formulario
$string['edittemplate'] = 'Editando plantilla: "{$a->type}" ({$a->language})';
$string['enabled'] = 'Habilitado';
$string['subject'] = 'Asunto del correo';
$string['body'] = 'Cuerpo del correo';
$string['missingsubject'] = 'El asunto es obligatorio';
$string['missingbody'] = 'El cuerpo del correo es obligatorio';
$string['template_saved'] = 'Plantilla guardada';
$string['placeholderhelp'] = 'Visita <a target="_blank" href="/local/engagement_email/index.php">esta página</a> para ver la lista de campos disponibles';

// Marcadores de posición
$string['availableplaceholders'] = 'Campos disponibles';
$string['globalhelp'] = 'Esta página muestra los campos que puedes usar en las plantillas.
Los valores mostrados en esta tabla son TUS valores como vista previa, serán reemplazados por los valores de los destinatarios cuando se envíe el correo.';
$string['welcome'] = 'Bienvenida';
$string['defaultprofile'] = 'Perfil de usuario básico';
$string['customprofile'] = 'Campos personalizados de usuario';
$string['defaultcourse'] = 'Información básica del curso';
$string['customcourse'] = 'Campos personalizados de curso';
$string['advanced'] = 'Otros campos';
$string['fieldname'] = 'Nombre del campo';
$string['yourvalue'] = 'Valor de vista previa';
$string['resetpass'] = 'Restablece tu contraseña aquí';
$string['coursecatalog'] = 'Catálogo de cursos';
$string['createcourselink'] = '<a href="' . (new \moodle_url('/my/'))->out() . '">Crear curso</a>';
$string['coursesharelink'] = '<a href="{$a->courseurl}">{$a->courseurl}</a>';


$string['privacy:metadata'] = 'Este plugin solo envía correos. No almacena ningún dato personal.';



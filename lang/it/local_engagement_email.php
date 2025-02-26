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

$string['pluginname'] = 'Email di coinvolgimento';

$string['manageemails'] = 'Gestisci email';

// Impostazioni
$string['engagement_email_enabled'] = 'Abilita email di coinvolgimento';
$string['engagement_email_enabled_desc'] = 'Abilita l\'invio di email di coinvolgimento personalizzate basate su eventi';
$string['senderaddress'] = 'Account mittente';
$string['senderaddress_desc'] = 'Account da utilizzare come mittente per le email di coinvolgimento';

// Gestione
$string['available_emails_header'] = 'Email di coinvolgimento disponibili';
$string['resetfilters'] = 'Reimposta filtri';
$string['eventname'] = 'Nome evento';
$string['test'] = 'Test';

// Eventi supportati
$string['user_created'] = 'Utente creato';
$string['course_created'] = 'Corso creato';
$string['user_enrolment_created'] = 'Iscrizione utente creata';
$string['course_completed'] = 'Corso completato';

// Gestori di messaggi
$string['messageprovider:user_created'] = 'Utente creato';
$string['messageprovider:course_created'] = 'Corso creato';
$string['messageprovider:user_enrolment_created'] = 'Iscrizione utente creata';
$string['messageprovider:course_completed'] = 'Corso completato';

// Disiscrizione dalle notifiche email
$string['unsubscribe:email'] = 'Notifiche email';
$string['profile:subscribe'] = 'Iscriviti a tutte le email';
$string['profile:unsubscribe'] = 'Disiscriviti da tutte le email';
$string['confirm:subscribe'] = 'Iscriviti a tutte le notifiche email?';
$string['confirm:unsubscribe'] = 'Sei sicuro di voler disiscriverti da tutte le notifiche email?';
$string['subscribe'] = 'Iscritto a tutte le notifiche email';
$string['unsubscribe'] = 'Disiscritto da tutte le notifiche email';
$string['error:subscribe'] = 'Errore durante l\'iscrizione alle notifiche email';
$string['error:unsubscribe'] = 'Errore durante la disiscrizione dalle notifiche email';

// Modelli predefiniti
$string['user_created:emailsubject'] = 'Benvenuto su [[sitename]]!';
$string['user_created:emailbody'] = '<p>Caro [[user:fullname]],</p>
<p>Benvenuto sulla nostra piattaforma di apprendimento [[sitelink]].</p>
<p>Ora puoi creare corsi con l\'AI. Crea il tuo primo corso ora! [[adv:coursecreatelink]]</p>
<p>Puoi anche iscriverti ai corsi di altri creatori, vedi il catalogo <a href="[[coursecatalogurl]]">qui</a>.</p>';
$string['course_created:emailsubject'] = 'Corso creato!';
$string['course_created:emailbody'] = '<p>Caro [[user:fullname]],</p>
<p>Complimenti per aver creato un nuovo corso chiamato [[course:fullname]].</p>
<p>Il tuo corso è pronto! Puoi accedervi <a href="[[course:url]]">qui</a>.</p>
<p>Condividilo con i tuoi amici/studenti: [[adv:coursesharelink]]</p>
<p>Crea un altro corso qui: [[adv:coursecreatelink]]</p>';
$string['user_enrolment_created:emailsubject'] = 'Sei ora iscritto a [[course:fullname]]';
$string['user_enrolment_created:emailbody'] = '<p>Caro [[user:fullname]],</p>
<p>Sei ora iscritto al corso [[course:fullname]].</p>
<p>Invita i tuoi amici a unirsi a te: [[adv:coursesharelink]]</p>
<p>Puoi anche creare i tuoi corsi con l\'AI: [[adv:coursecreatelink]]</p>
<p>Goditi il tuo corso su [[sitelink]]!</p>';
$string['course_completed:emailsubject'] = 'Hai completato il corso [[course:fullname]]!';
$string['course_completed:emailbody'] = '<p>Caro [[user:fullname]],</p>
<p>Hai completato con successo [[course:fullname]].</p>
<p>[[adv:certificate_cta]]</p>
<p>Se ti è piaciuto questo corso, condividilo con i tuoi amici: [[adv:coursesharelink]]</p>
<p>Puoi creare i tuoi corsi con l\'AI: [[adv:coursecreatelink]]</p>
<p>E iscriviti ad altri corsi, vedi il catalogo <a href="[[coursecatalogurl]]">qui</a>.</p>';
$string['get_certificate'] = '<p>Ottieni il tuo certificato <a href="{$a}">qui</a>.</p>';

// Modulo
$string['edittemplate'] = 'Modifica modello: "{$a->type}" ({$a->language})';
$string['enabled'] = 'Abilitato';
$string['subject'] = 'Oggetto';
$string['body'] = 'Corpo';
$string['missingsubject'] = 'L\'oggetto è obbligatorio';
$string['missingbody'] = 'Il corpo è obbligatorio';
$string['template_saved'] = 'Modello salvato';
$string['placeholderhelp'] = 'Visita <a target="_blank" href="/local/engagement_email/index.php">questa pagina</a> per vedere l\'elenco dei campi disponibili';

// Segnaposto
$string['availableplaceholders'] = 'Segnaposto disponibili';
$string['globalhelp'] = 'Le tabelle in questa pagina mostrano i segnaposto disponibili che possono essere utilizzati nei modelli di messaggio.
I valori mostrati in questa tabella sono i TUOI valori come anteprima, saranno sostituiti dai valori dei destinatari quando l\'email di benvenuto verrà inviata.';
$string['welcome'] = 'Benvenuto';
$string['defaultprofile'] = 'Profilo utente di base';
$string['customprofile'] = 'Campi del profilo personalizzati';
$string['defaultcourse'] = 'Informazioni di base sul corso';
$string['customcourse'] = 'Campi del corso personalizzati';
$string['advanced'] = 'Altri campi';
$string['fieldname'] = 'Segnaposto';
$string['yourvalue'] = 'Valore di anteprima';
$string['resetpass'] = 'Reimposta la tua password qui';
$string['coursecatalog'] = 'Catalogo dei corsi';
$string['createcourselink'] = '<a href="' . (new \moodle_url('/my/'))->out() . '">Crea corso</a>';
$string['coursesharelink'] = '<a href="{$a->courseurl}">{$a->courseurl}</a>';


$string['privacy:metadata'] = 'Questo plugin invia solo email. Non memorizza alcun dato personale.';



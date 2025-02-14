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
$string['pluginname'] = 'Emails d\'engagement';

$string['manageemails'] = 'Gérer les emails';

$string['engagement_email_enabled'] = 'Activer les emails d\'engagement';
$string['engagement_email_enabled_desc'] = 'Activer l\'envoi d\'emails d\'engagement personnalisés basés sur des événements';

$string['available_emails_header'] = 'Emails d\'engagement disponibles';
$string['resetfilters'] = 'Réinitialiser les filtres';
$string['eventname'] = 'Nom de l\'événement';
$string['test'] = 'Test';

// Événements pris en charge
$string['user_created'] = 'Utilisateur créé';
$string['course_created'] = 'Cours créé';
$string['user_enrolment_created'] = 'Inscription de l\'utilisateur créée';
$string['course_completed'] = 'Cours terminé';

// Modèles par défaut
$string['user_created:emailsubject'] = 'Bienvenue sur [[sitename]] !';
$string['user_created:emailbody'] = '<p>Cher [[fullname]],</p>
<p>Bienvenue sur notre plateforme d\'apprentissage [[sitelink]].</p>
<p>Vous pouvez maintenant créer des cours avec l\'IA. Créez votre premier cours maintenant ! [[genailink]]</p>
<p>Vous pouvez également vous inscrire à des cours créés par d\'autres utilisateurs, consultez le catalogue <a href="[[coursecatalogurl]]">ici</a>.</p>';
$string['course_created:emailsubject'] = 'Cours créé !';
$string['course_created:emailbody'] = '<p>Cher [[fullname]],</p>
<p>Félicitations pour la création d\'un nouveau cours appelé [[coursename]].</p>
<p>Votre cours est prêt à être utilisé ! Vous pouvez y accéder <a href="[[courseurl]]">ici</a>.</p>
<p>Partagez-le avec vos amis/étudiants : [[coursesharelink]]</p>
<p>Créez un autre cours ici : [[genailink]]</p>';
$string['user_enrolment_created:emailsubject'] = 'Vous êtes maintenant inscrit à [[coursename]]';
$string['user_enrolment_created:emailbody'] = '<p>Cher [[fullname]],</p>
<p>Vous êtes maintenant inscrit au cours [[coursename]].</p>
<p>Invitez vos amis à vous rejoindre : [[coursesharelink]]</p>
<p>Vous pouvez également créer vos propres cours avec l\'IA : [[genailink]]</p>
<p>Profitez de votre cours sur [[sitelink]]!</p>';
$string['course_completed:emailsubject'] = 'Vous avez terminé le cours [[coursename]] !';
$string['course_completed:emailbody'] = '<p>Cher [[fullname]],</p>
<p>Vous avez terminé avec succès [[coursename]].</p>
<p>[[certificate_cta]]</p>
<p>Si vous avez apprécié ce cours, partagez-le avec vos amis : [[coursesharelink]]</p>
<p>Vous pouvez créer vos propres cours avec l\'IA : [[genailink]]</p>
<p>Et vous inscrire à d\'autres cours, consultez le catalogue <a href="[[coursecatalogurl]]">ici</a>.</p>';
$string['get_certificate'] = '<p>Obtenez votre certificat <a href="[[certificateurl]]">ici</a>.</p>';

$string['privacy:metadata'] = 'Ce plugin envoie uniquement des emails. Il ne stocke aucune donnée personnelle.';



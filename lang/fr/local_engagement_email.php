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

// Settings
$string['engagement_email_enabled'] = 'Activer les emails d\'engagement';
$string['engagement_email_enabled_desc'] = 'Activer l\'envoi d\'emails d\'engagement personnalisés basés sur des événements';
$string['senderaddress'] = 'Adresse de l\'expéditeur';
$string['senderaddress_desc'] = 'Compte à utiliser comme expéditeur pour les emails d\'engagement';

// Management
$string['available_emails_header'] = 'Emails d\'engagement disponibles';
$string['resetfilters'] = 'Réinitialiser les filtres';
$string['eventname'] = 'Nom de l\'événement';
$string['test'] = 'Test';

// Supported events
$string['user_created'] = 'Utilisateur créé';
$string['course_created'] = 'Cours créé';
$string['user_enrolment_created'] = 'Inscription de l\'utilisateur créée';
$string['course_completed'] = 'Cours terminé';

// Default templates
$string['user_created:emailsubject'] = 'Bienvenue sur [[sitename]]!';
$string['user_created:emailbody'] = '<p>Cher [[user:fullname]],</p>
<p>Bienvenue sur notre plateforme d\'apprentissage [[sitelink]].</p>
<p>Vous pouvez maintenant créer des cours avec l\'IA. Créez votre premier cours maintenant! [[adv:coursecreatelink]]</p>
<p>Vous pouvez également vous inscrire à des cours créés par d\'autres utilisateurs, consultez le catalogue <a href="[[coursecatalogurl]]">ici</a>.</p>';
$string['course_created:emailsubject'] = 'Cours créé!';
$string['course_created:emailbody'] = '<p>Cher [[user:fullname]],</p>
<p>Félicitations pour la création d\'un nouveau cours appelé [[course:fullname]].</p>
<p>Votre cours est prêt à être utilisé! Vous pouvez y accéder <a href="[[course:url]]">ici</a>.</p>
<p>Partagez-le avec vos amis/étudiants : [[adv:coursesharelink]]</p>
<p>Créez un autre cours ici : [[adv:coursecreatelink]]</p>';
$string['user_enrolment_created:emailsubject'] = 'Vous êtes maintenant inscrit à [[course:fullname]]';
$string['user_enrolment_created:emailbody'] = '<p>Cher [[user:fullname]],</p>
<p>Vous êtes maintenant inscrit au cours [[course:fullname]].</p>
<p>Invitez vos amis à vous rejoindre : [[adv:coursesharelink]]</p>
<p>Vous pouvez également créer vos propres cours avec l\'IA : [[adv:coursecreatelink]]</p>
<p>Profitez de votre cours sur [[sitelink]]!</p>';
$string['course_completed:emailsubject'] = 'Vous avez terminé le cours [[course:fullname]]!';
$string['course_completed:emailbody'] = '<p>Cher [[user:fullname]],</p>
<p>Vous avez terminé avec succès le cours [[course:fullname]].</p>
<p>[[adv:certificate_cta]]</p>
<p>Si vous avez apprécié ce cours, partagez-le avec vos amis : [[adv:coursesharelink]]</p>
<p>Vous pouvez créer vos propres cours avec l\'IA : [[adv:coursecreatelink]]</p>
<p>Et vous inscrire à d\'autres cours, consultez le catalogue <a href="[[coursecatalogurl]]">ici</a>.</p>';
$string['get_certificate'] = '<p>Obtenez votre certificat <a href="{$a}">ici</a>.</p>';

// Form
$string['edittemplate'] = 'Modification du modèle : "{$a->type}" ({$a->language})';
$string['enabled'] = 'Activé';
$string['subject'] = 'Sujet';
$string['body'] = 'Corps';
$string['missingsubject'] = 'Le sujet est requis';
$string['missingbody'] = 'Le corps est requis';
$string['template_saved'] = 'Modèle enregistré';
$string['placeholderhelp'] = 'Visitez <a target="_blank" href="/local/engagement_email/index.php">cette page</a> pour voir la liste des champs disponibles';

// Placeholders
$string['availableplaceholders'] = 'Emplacements disponibles';
$string['globalhelp'] = 'Les tableaux de cette page montrent les emplacements disponibles qui peuvent être utilisés dans les modèles de message.
Les valeurs affichées dans ce tableau sont VOS valeurs en tant que prévisualisation, elles seront remplacées par les valeurs des destinataires lorsque l\'email de bienvenue sera envoyé.';
$string['welcome'] = 'Bienvenue';
$string['defaultprofile'] = 'Profil utilisateur de base';
$string['customprofile'] = 'Champs de profil personnalisés';
$string['defaultcourse'] = 'Informations de base sur le cours';
$string['customcourse'] = 'Champs de cours personnalisés';
$string['advanced'] = 'Autres champs';
$string['fieldname'] = 'Emplacement';
$string['yourvalue'] = 'Valeur de prévisualisation';
$string['resetpass'] = 'Réinitialisez votre mot de passe ici';
$string['coursecatalog'] = 'Catalogue de cours';
$string['createcourselink'] = '<a href="/my/">Créer un cours</a>';
$string['coursesharelink'] = '<a href="{$a->courseurl}">{$a->courseurl}</a>';


$string['privacy:metadata'] = 'Ce plugin envoie uniquement des emails. Il ne stocke aucune donnée personnelle.';



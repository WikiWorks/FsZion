# ChameleonThemes

New FamilySearch wiki skin


1) Download and place the files in a directory called ChameleonThemes in your extensions/ folder.

2) Install extensions Bootstrap and Chameleon

3) Add to LocalSettings.php:

```
wfLoadExtension( 'Bootstrap' );
wfLoadSkin( 'chameleon' );
 
wfLoadExtension( 'ChameleonThemes' );
$wgDefaultSkin = 'chameleon';

$wgChameleonThemesTheme = 'familysearch';
```


4) Add the following in MediaWiki:Secondary-menu

```
* Research Wiki
** mainpage| Wiki Home
** FamilySearch Wiki:FamilySearch Research Wiki| About the Wiki
** Online Genealogy Records by Location| Online Genealogy Records
** Guided Research for Online Records| Guided Research
** Research Resources| Research Resources
** FamilySearch Wiki:Purpose, Policies, and Procedures | Wiki Policies
* Centers/Libraries
** https://www.familysearch.org/en/library/|FamilySearch Library
** https://www.familysearch.org/fhcenters/locations|FamilySearch Centers
** https://www.familysearch.org/en/affiliates/about|FS Affiliate Libraries
* Give Feedback
** FamilySearch Wiki:Submit Content or Report a Problem|Submit Wiki Content
** FamilySearch Wiki:Submit Content or Report a Problem|Report a Problem
* Edit the Wiki
** FamilySearch Wiki:Upload File/Image|Upload File/Image
** Special:Mypage/Sandbox| Personal Sandbox
** FamilySearch Wiki:Wiki Contributor Updates| Contributor Updates
** Get_Involved_in_Wiki_Projects| Wiki Projects
** Help:Wiki University Tutorial| Wiki University
** FamilySearch Wiki:Manual of Style|Manual of Style
```
	
	

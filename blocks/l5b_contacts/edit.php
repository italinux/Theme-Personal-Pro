<?php 
/**
.---------------------------------------------------------------------.
|  @package: Theme Lazy5basic (a.k.a. theme Personal Pro)
|  @version: Latest on Github
|  @link:    http://italinux.com/personal-pro
|  @docs:    http://italinux.com/theme-personal-pro
|
|  @author: Matteo Montanari <matteo@italinux.com>
|  @link:   http://matteo-montanari.com
'---------------------------------------------------------------------'
.---------------------------------------------------------------------------.
| @copyright (c) 2019                                                       |
| ------------------------------------------------------------------------- |
| @license: Concrete5.org Marketplace Commercial Add-Ons & Themes License   |
|           http://concrete5.org/help/legal/commercial_add-on_license       |
|           or just: file://theme_lazy5basic/LICENSE.TXT                    |
|                                                                           |
| This program is distributed in the hope that it will be useful - WITHOUT  |
| ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or     |
| FITNESS FOR A PARTICULAR PURPOSE.                                         |
'---------------------------------------------------------------------------'
*/
defined('C5_EXECUTE') or die("Access Denied.");

use \Concrete\Block\Form\MiniSurvey;

$miniSurvey = new MiniSurvey($b);
$miniSurveyInfo = $miniSurvey->getMiniSurveyBlockInfo($b->getBlockID());

MiniSurvey::questionCleanup(intval($miniSurveyInfo['questionSetId']), $b->getBlockID());

?>
<script type="text/javascript">
  if (typeof itl_lazy_contacts_form === 'undefined') {
      var  itl_lazy_contacts_form = {};
  }
<?php if (is_object($b->getProxyBlock())) { ?>
    itl_lazy_contacts_form.thisbID=parseInt(<?php echo $b->getProxyBlock()->getBlockID()?>, 10);
<?php } else { ?>
    itl_lazy_contacts_form.thisbID=parseInt(<?php echo $b->getBlockID()?>, 10);
<?php } ?>
    itl_lazy_contacts_form.thisbtID=parseInt(<?php echo $b->getBlockTypeID()?>, 10);
</script>

<?php $this->inc('form.php', array('c' => $c,
                                   'b' => $b,
                                   'miniSurveyInfo' => $miniSurveyInfo,
                                   'miniSurvey' => $miniSurvey,
                                   'a' => $a,
                                   'bt' => $bt))?>

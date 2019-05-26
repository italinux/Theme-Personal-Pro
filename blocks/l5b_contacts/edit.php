<?php 
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

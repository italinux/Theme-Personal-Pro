<?php 
defined('C5_EXECUTE') or die("Access Denied.");

?>
<script type="text/javascript">
  if (typeof itl_lazy_contacts_form === 'undefined') {
      var itl_lazy_contacts_form = {};
  }
  itl_lazy_contacts_form.thisbID = 0; 
  itl_lazy_contacts_form.thisbtID = parseInt(<?php echo $bt->getBlockTypeID()?>, 10);
</script>

<?php $this->inc('form.php')?>

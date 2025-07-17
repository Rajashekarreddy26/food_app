<?= $this->extend('template/template_admin'); ?>
<?= $this->section('content'); ?>
<div id="client_body">
	<?= $this->include('invoice_tracking/client/client_body');	?>
</div>
<?= 
$this->endsection();
?>
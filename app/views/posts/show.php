<?php require APPROOT . '/views/inc/header.php'; ?>
<a href="<?php echo URLROOT;?>/posts" class="btn btn-dark mb-3">
<i class="fa fa-backward"></i> Previous Page</a>
<br>
<h1><?= $data['post']->title; ?></h1>
<div class="bg-info text-white p-2 mb-3">
    <strong>Written By:</strong> <u><?= $data['user']->name;?></u> on  <?= $data['post']->created_at;?>
</div>
<p><?php echo $data['post']->body; ?></p>

<?php if($data['post']->user_id == $_SESSION['user_id']) : ?>
  <hr>
  <a href="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['post']->id; ?>" class="btn btn-dark">Edit Post</a>

  <form class="pull-right" action="<?php echo URLROOT; ?>/posts/delete/<?php echo $data['post']->id; ?>" method="post">
    <input type="submit" value="Delete" class="btn btn-danger">
  </form>
<?php endif; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>



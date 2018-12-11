<?php require APPROOT . '/views/inc/header.php'; ?>
<a href="<?php echo URLROOT;?>/posts" class="btn btn-dark">
<i class="fa fa-backward"></i> Previous Page</a>
<div class="card card-body bg-light mt-5">
    <h2>Edit Post</h2>
    <p>Edit your post</p>
    <form action="<?= URLROOT; ?>/posts/edit/<?= $data['id'];?>"method="post">
        <div class="form-group">
            <label for="title">Title: <sup>*</sup></label>
            <input type="text" name="title" class="form-control form-control-lg 
            <?php echo(!empty($data['title_error'])) ? 'is-invalid' : '';?>" value="<?= $data['title'];?>">
            <span class="invalid-feedback"><?= $data['title_error'];?></span>
        </div>
        <div class="form-group">
            <label for="body">Body: <sup>*</sup></label>
           <textarea name="body" class="form-control form-control-lg 
            <?php echo(!empty($data['body_error'])) ? 'is-invalid' : '';?>"><?= $data['body'];?></textarea>
            <span class="invalid-feedback"><?= $data['body_error'];?></span>
        </div>
        <input type="submit" class="btn btn-success" value="Submit">
    </form>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
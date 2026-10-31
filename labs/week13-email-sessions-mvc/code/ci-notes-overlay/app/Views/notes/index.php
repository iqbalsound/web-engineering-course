<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><title>Notes</title></head><body><main>
<h1>Notes</h1>
<?php if (session()->getFlashdata('message')): ?><p role="status"><?= esc(session('message')) ?></p><?php endif; ?>
<?php foreach ((array) session('errors') as $err): ?><p role="alert"><?= esc($err) ?></p><?php endforeach; ?>
<form action="<?= site_url('notes') ?>" method="post"><?= csrf_field() ?>
  <p><input name="title" value="<?= esc(old('title') ?? '') ?>" required placeholder="Title"></p>
  <p><textarea name="body" placeholder="Body"><?= esc(old('body') ?? '') ?></textarea></p>
  <button>Save</button></form>
<?php foreach ($notes as $n): ?>
  <article><h2><?= esc($n['title']) ?></h2><p><?= esc($n['body'] ?? '') ?></p>
    <form action="<?= site_url('notes/' . $n['id'] . '/delete') ?>" method="post"><?= csrf_field() ?><button>Delete</button></form></article>
<?php endforeach; ?>
<?= $pager->links() ?></main></body></html>

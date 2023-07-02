<div class="mb-3">
    <label for="<?= $id ?? '' ?>" class="form-label"><?= $label ?? '' ?></label>
    <textarea rows="3" name="<?= $name ?? '' ?>" placeholder="<?= $placeholder ?? '' ?>" class="form-control <?= $error ? 'is-invalid' : '' ?>" id="<?= $id ?? "" ?>"><?= $value ?? '' ?></textarea>
    <div class="invalid-feedback"><?= $error ?? '' ?></div>
</div>
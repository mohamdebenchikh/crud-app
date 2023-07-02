<div class="mb-3">
    <label for="<?= $id ?? '' ?>" class="form-label"><?= $label ?? '' ?></label>
    <input type="<?= $type ?? 'text' ?>" placeholder="<?= $placeholder ?? '' ?>" value="<?= $value ?? '' ?>" name="<?= $name ?? '' ?>" class="form-control <?= $error ? 'is-invalid' : '' ?>" id="<?= $id ?? "" ?>">
    <div class="invalid-feedback"><?= $error ?? '' ?></div>
</div>
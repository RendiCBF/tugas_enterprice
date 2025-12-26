<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">
                <h3 class="mb-0">Edit Data User</h3>
            </div>
            <div class="card-body">
                <form action="<?= base_url('users/update/' . $user['user_id']); ?>" method="post">
                    <?= csrf_field(); ?>
                    
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?= $user['username']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= $user['email']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="role_id" class="form-label">Role</label>
                        <select class="form-select" name="role_id" required>
                            <option value="1" <?= ($user['role_id'] == 1) ? 'selected' : ''; ?>>Admin</option>
                            <option value="2" <?= ($user['role_id'] == 2) ? 'selected' : ''; ?>>Manager</option>
                            <option value="3" <?= ($user['role_id'] == 3) ? 'selected' : ''; ?>>Staff</option>
                        </select>
                        <small class="text-muted">Pilih role sesuai hak akses user.</small>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?= base_url('users'); ?>" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
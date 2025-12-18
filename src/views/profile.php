<?php ob_start() ?>

<h1>Profil</h1>

<?php if (!empty($error['global'])): ?>
    <p><?= $error['global'] ?></p>
<?php endif; ?>

<?php if (!empty($_SESSION['success'])): ?>
    <p><?= $_SESSION['success'] ?></p>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (!isset($_SESSION['connect']) || !$_SESSION['connect']) { ?>
    <h2>Créer un compte</h2>
    <form method="post">
        <label for="firstname">Prénom : </label>
        <input id="firstname" type="text" name="firstname" value="<?= $_POST['firstname'] ?? '' ?>">
        <?php if (!empty($error['firstname'])): ?>
            <small><?= $error['firstname'] ?></small>
        <?php endif; ?>

        <label for="name">Nom : </label>
        <input id="name" type="text" name="name" value="<?= $_POST['name'] ?? '' ?>">
        <?php if (!empty($error['name'])): ?>
            <small><?= $error['name'] ?></small>
        <?php endif; ?>

        <label for="password">Mot de Passe : </label>
        <input id="password" type="password" name="password">
        <?php if (!empty($error['password'])): ?>
            <small><?= $error['password'] ?></small>
        <?php endif; ?>

        <label for="verifyPassword">Vérifier le mot de passe : </label>
        <input id="verifyPassword" type="password" name="verifyPassword">

        <label for="email">E-mail : </label>
        <input id="email" type="email" name="email" value="<?= $_POST['email'] ?? '' ?>">
        <?php if (!empty($error['email'])): ?>
            <small><?= $error['email'] ?></small>
        <?php endif; ?>

        <label for="iban">Numéro d'IBAN : </label>
        <input id="iban" type="text" name="iban" value="<?= $_POST['iban'] ?? '' ?>">
        <?php if (!empty($error['iban'])): ?>
            <small><?= $error['iban'] ?></small>
        <?php endif; ?>

        <button type="submit" name="create" value="1">Envoyer</button>
    </form>

    <h2>Se connecter</h2>
    <form method="post">
        <label for="email-login">E-mail : </label>
        <input id="email-login" type="email" name="email">
        <?php if (!empty($error['login'])): ?>
            <small><?= $error['login'] ?></small>
        <?php endif; ?>

        <label for="password-login">Mot de Passe : </label>
        <input id="password-login" type="password" name="password">

        <button type="submit" name="connect" value="1">Envoyer</button>
    </form>
<?php } else { ?>

    <?php if (isset($_GET['action']) && $_GET['action'] === 'update_info'): ?>
        <h2>Mettre à jour mes informations</h2>
        <?php if ($userData): ?>
            <form method="post">
                <label for="firstname-update">Prénom : </label>
                <input id="firstname-update" type="text" name="firstname" value="<?= htmlspecialchars($userData['firstname']) ?>">
                <?php if (!empty($error['firstname'])): ?>
                    <small><?= $error['firstname'] ?></small>
                <?php endif; ?>

                <label for="name-update">Nom : </label>
                <input id="name-update" type="text" name="name" value="<?= htmlspecialchars($userData['name']) ?>">
                <?php if (!empty($error['name'])): ?>
                    <small><?= $error['name'] ?></small>
                <?php endif; ?>

                <label for="email-update">E-mail : </label>
                <input id="email-update" type="email" name="email" value="<?= htmlspecialchars($userData['email']) ?>">
                <?php if (!empty($error['email'])): ?>
                    <small><?= $error['email'] ?></small>
                <?php endif; ?>

                <label for="iban-update">Numéro d'IBAN : </label>
                <input id="iban-update" type="text" name="iban" value="<?= htmlspecialchars($userData['iban']) ?>">
                <?php if (!empty($error['iban'])): ?>
                    <small><?= $error['iban'] ?></small>
                <?php endif; ?>

                <button type="submit" name="updateInfo" value="1">Mettre à jour mes informations</button>
            </form>
            <a href="profile">Annuler</a>
        <?php endif; ?>
    <?php else: ?>
        <h2>Mes informations</h2>
        <?php if ($userData): ?>
            <div class="informations">
                <p><strong>Prénom :</strong> <?= htmlspecialchars($userData['firstname']) ?></p>
                <p><strong>Nom :</strong> <?= htmlspecialchars($userData['name']) ?></p>
                <p><strong>Email :</strong> <?= htmlspecialchars($userData['email']) ?></p>
                <p><strong>IBAN :</strong> <?= htmlspecialchars($userData['iban']) ?></p>
            </div>
        <?php endif; ?>
        <a href="?action=update_info">Mettre à jour mes coordonnées</a>
    <?php endif; ?>

    <h2>Paramètres</h2>
    <div class="settings-container">
        <div class="setting-item">
            <span>Mode Sombre</span>
            <label class="switch">
                <input type="checkbox" id="dark-mode-toggle" name="dark_mode">
                <span class="slider round"></span>
            </label>
        </div>

        <div class="setting-item">
            <span>Notifications</span>
            <label class="switch">
                <input type="checkbox" id="notifications-toggle" name="notifications" checked>
                <span class="slider round"></span>
            </label>
        </div>
    </div>

    <form method="post">
        <button type="submit" name="deconnect" value="1">Se déconnecter</button>
    </form>

    <?php if (isset($_GET['action']) && $_GET['action'] === 'change_password'): ?>
        <h2>Changer mon mot de passe</h2>
        <form method="post">
            <label for="current-password">Mot de passe actuel : </label>
            <input id="current-password" type="password" name="current_password" required>
            <?php if (!empty($error['current_password'])): ?>
                <small><?= $error['current_password'] ?></small>
            <?php endif; ?>

            <label for="new-password">Nouveau mot de passe : </label>
            <input id="new-password" type="password" name="new_password" required>
            <?php if (!empty($error['new_password'])): ?>
                <small><?= $error['new_password'] ?></small>
            <?php endif; ?>

            <label for="verify-new-password">Confirmer le nouveau mot de passe : </label>
            <input id="verify-new-password" type="password" name="verify_new_password" required>

            <?php if (!empty($error['password_global'])): ?>
                <small><?= $error['password_global'] ?></small>
            <?php endif; ?>

            <button type="submit" name="updatePassword" value="1">Changer le mot de passe</button>
        </form>
        <a href="profile">Annuler</a>
    <?php else: ?>
        <a href="?action=change_password">Changer mon mot de passe</a>
    <?php endif; ?>

    <?php if (isset($_GET['action']) && $_GET['action'] === 'delete_account'): ?>
        <h2>Supprimer mon compte</h2>
        <p>Cette action est irréversible. Veuillez confirmer avec votre mot de passe.</p>
        <form method="post">
            <label for="password-delete">Mot de passe : </label>
            <input id="password-delete" type="password" name="password" required>
            <?php if (!empty($error['delete'])): ?>
                <small><?= $error['delete'] ?></small>
            <?php endif; ?>
            <button type="submit" name="confirmDelete" value="1">Supprimer définitivement mon compte</button>
        </form>
        <a href="profile">Annuler</a>
    <?php else: ?>
        <a href="?action=delete_account">Supprimer mon compte</a>
    <?php endif; ?>

<?php } ?>

<?php
render('default', true, [
    'title' => 'Profil',
    'css' => 'profile',
    'content' => ob_get_clean(),
    'js' => 'theme',

]);
?>
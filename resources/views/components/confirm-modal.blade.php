{{-- Confirm Modal --}}
<div class="confirm-overlay" id="confirmOverlay" style="display:none;">
    <div class="confirm-modal" id="confirmModal">
        <div class="confirm-icon" id="confirmIcon">🗑</div>
        <h3 class="confirm-title" id="confirmTitle">Move to Trash?</h3>
        <p class="confirm-message" id="confirmMessage">This shoe will be moved to trash.</p>
        <div class="confirm-actions">
            <button class="confirm-cancel-btn" onclick="closeConfirm()">Cancel</button>
            <button class="confirm-ok-btn" id="confirmOkBtn">Confirm</button>
        </div>
    </div>
</div>

<script>
(function () {
    let _onConfirm = null;

    window.showConfirm = function ({ title, message, icon, okLabel, okClass, onConfirm }) {
        document.getElementById('confirmTitle').textContent   = title   ?? 'Are you sure?';
        document.getElementById('confirmMessage').textContent = message ?? '';
        document.getElementById('confirmIcon').textContent    = icon    ?? '⚠';

        const okBtn = document.getElementById('confirmOkBtn');
        okBtn.textContent  = okLabel  ?? 'Confirm';
        okBtn.className    = 'confirm-ok-btn ' + (okClass ?? '');

        _onConfirm = onConfirm ?? null;

        document.getElementById('confirmOverlay').style.display = 'flex';
        // Trigger animation
        requestAnimationFrame(() => {
            document.getElementById('confirmModal').classList.add('confirm-open');
        });
    };

    window.closeConfirm = function () {
        const modal = document.getElementById('confirmModal');
        modal.classList.remove('confirm-open');
        modal.classList.add('confirm-closing');
        modal.addEventListener('animationend', () => {
            document.getElementById('confirmOverlay').style.display = 'none';
            modal.classList.remove('confirm-closing');
            _onConfirm = null;
        }, { once: true });
    };

    document.getElementById('confirmOkBtn').addEventListener('click', () => {
        if (_onConfirm) _onConfirm();
        closeConfirm();
    });

    // Close on overlay click
    document.getElementById('confirmOverlay').addEventListener('click', function (e) {
        if (e.target === this) closeConfirm();
    });
})();
</script>

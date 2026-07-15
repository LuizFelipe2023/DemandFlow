document.addEventListener('DOMContentLoaded', function () {
    const editModal = document.getElementById('editHistoryModal');
    const editForm = document.getElementById('editHistoryForm');

    if (editModal && editForm) {
        
        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            
            const historyId = button.getAttribute('data-history-id');
            const type = button.getAttribute('data-history-type');
            const description = button.getAttribute('data-history-description');
            
            editModal.querySelector('#edit_type').value = type || 'COMMENT';
            editModal.querySelector('#edit_description').value = description || '';
            
            const demandId = editForm.getAttribute('data-demand-id');
            editForm.action = `/demands/${demandId}/histories/${historyId}`;
        });

       
        const closeButtons = editModal.querySelectorAll('[data-bs-dismiss="modal"], [data-bs-close="modal"], [data-dismiss="modal"]');
        
        closeButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
               
                if (window.bootstrap && bootstrap.Modal) {
                    const modalInstance = bootstrap.Modal.getInstance(editModal);
                    if (modalInstance) {
                        modalInstance.hide();
                        return;
                    }
                }
           
                editModal.classList.remove('show');
                editModal.style.display = 'none';
                
          
                document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
                    backdrop.remove();
                });
                
                document.body.classList.remove('modal-open');
                document.body.style.removeProperty('overflow');
                document.body.style.removeProperty('padding-right');
            });
        });
    }
});
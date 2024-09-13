document.addEventListener('DOMContentLoaded', function() {

    document.getElementById('user-filter-btn').addEventListener('click', function() {
        const userName = document.getElementById('filter-user-name').value.toLowerCase();
        const userEmail = document.getElementById('filter-user-email').value.toLowerCase();
        const userRole = document.getElementById('filter-user-role').value.toLowerCase();
        const userTable = document.getElementById('user-table');
        const rows = userTable.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            const name = cells[0].textContent.toLowerCase();
            const email = cells[1].textContent.toLowerCase();
            const role = cells[2].textContent.toLowerCase();

            const nameMatch = !userName || name.includes(userName);
            const emailMatch = !userEmail || email.includes(userEmail);
            const roleMatch = !userRole || role.includes(userRole);

            if (nameMatch && emailMatch && roleMatch) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    });

    document.getElementById('user-clear-filter').addEventListener('click', function() {
        document.getElementById('filter-user-name').value = '';
        document.getElementById('filter-user-email').value = '';
        document.getElementById('filter-user-role').value = '';

        const rows = document.querySelectorAll('#user-table tbody tr');
        rows.forEach(row => {
            row.style.display = '';
        });
    });


    document.getElementById('category-filter-btn').addEventListener('click', function() {
        const nameFilter = document.getElementById('filter-category-name').value.toLowerCase();
        const descriptionFilter = document.getElementById('filter-category-description').value.toLowerCase();
        
        const rows = document.querySelectorAll('#category-table tbody tr');
        rows.forEach(row => {
            const name = row.cells[1].textContent.toLowerCase();
            const description = row.cells[2].textContent.toLowerCase();
            
            if (name.includes(nameFilter) && description.includes(descriptionFilter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
    
    document.getElementById('clear-category-filter').addEventListener('click', function() {
        document.getElementById('filter-category-name').value = '';
        document.getElementById('filter-category-description').value = '';
        
        const rows = document.querySelectorAll('#category-table tbody tr');
        rows.forEach(row => {
            row.style.display = '';
        });
    });

    document.getElementById('lesson-filter-btn').addEventListener('click', function() {
        const nameFilter = document.getElementById('filter-lesson-name').value.toLowerCase().split(' ');
        const categoryFilter = document.getElementById('filter-lesson-category').value.toLowerCase().split(' ');
        const instructorFilter = document.getElementById('filter-lesson-instructor').value.toLowerCase().split(' ');

        const rows = document.querySelectorAll('#lesson-table tbody tr');
        rows.forEach(row => {
            const name = row.cells[1].textContent.toLowerCase();
            const category = row.cells[3].textContent.toLowerCase();
            const instructor = row.cells[4].textContent.toLowerCase();

            const nameMatch = nameFilter.length === 0 || nameFilter.some(word => name.includes(word));
            const categoryMatch = categoryFilter.length === 0 || categoryFilter.some(word => category.includes(word));
            const instructorMatch = instructorFilter.length === 0 || instructorFilter.some(word => instructor.includes(word));

            if (nameMatch && categoryMatch && instructorMatch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    document.getElementById('clear-lesson-filter').addEventListener('click', function() {
        document.getElementById('filter-lesson-name').value = '';
        document.getElementById('filter-lesson-category').value = '';
        document.getElementById('filter-lesson-instructor').value = '';

        const rows = document.querySelectorAll('#lesson-table tbody tr');
        rows.forEach(row => {
            row.style.display = '';
        });
    });

            // Retrieve the active tab from local storage
            var activeTab = localStorage.getItem('activeTab');
            if (activeTab) {
                var tab = document.querySelector(activeTab);
                if (tab) {
                    var tabInstance = new bootstrap.Tab(tab);
                    tabInstance.show();
                }
            }
    
            // Store the active tab in local storage on tab change
            var tabs = document.querySelectorAll('.nav-link');
            tabs.forEach(function (tab) {
                tab.addEventListener('shown.bs.tab', function (event) {
                    localStorage.setItem('activeTab', '#' + event.target.id);
                });
            });
});
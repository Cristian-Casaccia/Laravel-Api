
routeUrl = 'breweries';
let toastData = [];
let login = false;
document.addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
        document.getElementById("sendButton").click();
    }
});
async function GetValidateToken() {
    const localToken = getLocalToken();

    try {
        const tokenResponse = await fetch('/api/user-profile', {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${localToken}`,
                'Content-Type': 'application/json',
            }
        });
        if (!tokenResponse.ok) {
            alert('Sessione scaduta o token non valido.');
            window.location.href = '/login';
        }
        var element = document.getElementById('call_container');
        document.getElementById('token').value = localToken;
        document.getElementById('url').value = "https://api.openbrewerydb.org/breweries";
        element.classList.remove('disp_none');
        document.getElementById("sendButton").click();
    } catch (error) {
        console.error('Errore nella chiamata API:', error);
        window.location.href = '/login';
    }

}

async function UserLogout() {
    const localToken = getLocalToken();

    try {
        const tokenResponse = await fetch('/api/logout', {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${localToken}`,
                'Content-Type': 'application/json',
            }
        });
        if (tokenResponse.ok) {
            window.location.href = '/login';
        }
    } catch (error) {
        console.error('Errore nella chiamata API:', error);
        window.location.href = '/login';
    }

}
async function fetchUserProfile() {
    const bearerToken = document.getElementById('token').value;
    const url = document.getElementById('url').value;
    const resultDiv = document.getElementById('result');

    // Nascondi il risultato inizialmente
    resultDiv.style.display = 'none';
    resultDiv.textContent = 'Sto facendo la richiesta...';

    try {
        // Prima richiesta GET per ottenere il profilo utente
        const response = await fetch('api/user-profile', {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${bearerToken}`,
                'Content-Type': 'application/json',
            }
        });

        if (response.ok) {
            const data = await response.json();

            resultDiv.style.display = 'block';
            resultDiv.textContent = `Token valido, dati utente recuperati con successo: ${JSON.stringify(data, null, 2)}`;
            resultDiv.style.backgroundColor = 'green';
            resultDiv.style.borderColor = '#00acc1';

            const breweryResponse = await fetch('/breweries', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    url: url
                })
            });

            if (breweryResponse.ok) {
                const results = await breweryResponse.json();
                console.log('Risultati della richiesta POST:', results);


                if (results.columns && results.rows) {

                    const columnContainer = document.getElementById('api_table-column');
                    columnContainer.innerHTML = '';
                    const headerRow = document.createElement('tr');


                    results.columns.forEach(column => {
                        const th = document.createElement('th');
                        th.textContent = column;
                        headerRow.appendChild(th);
                    });
                    columnContainer.appendChild(headerRow);


                    const rowContainer = document.getElementById('api_table-rows');
                    rowContainer.innerHTML = '';
                    results.rows.forEach(row => {
                        const rowElement = document.createElement('tr');
                        row.forEach(cell => {
                            const td = document.createElement('td');
                            td.textContent = cell;
                            rowElement.appendChild(td);
                        });
                        rowContainer.appendChild(rowElement);
                    });

                    if ($.fn.DataTable.isDataTable('#breweries-table')) {
                        $('#breweries-table').DataTable().destroy();
                    }


                    new DataTable('#breweries-table', {

                        fixedColumns: {
                            left: 1
                        },
                        paging: true,
                        searching: true,
                        scrollCollapse: true,
                        scrollX: true,
                        scrollY: '400px',
                    });

                    // Mostra il messaggio di successo
                    toastData['type'] = 'success';
                    toastData['message'] = 'Dati caricati con successo!';
                    toastMessage(toastData);
                } else {
                    console.error('Dati mancanti nella risposta:', results);
                    // alert('Dati mancanti nella risposta');
                }
            } else {
                const errorData = await breweryResponse.json();
                console.error('Errore risposta POST:', errorData);
                resultDiv.style.display = 'block';
                resultDiv.textContent = `Errore nella risposta del server: ${errorData.error || 'Dati non validi ricevuti'}`;
                resultDiv.classList.add('error');
            }

        } else {
            resultDiv.style.display = 'block';
            resultDiv.textContent = `Errore: ${response.statusText}`;
            resultDiv.classList.add('error');
        }
    } catch (error) {
        console.error('Errore durante la chiamata API:', error);
        resultDiv.style.display = 'block';
        resultDiv.textContent = `Errore durante la chiamata API: ${error.message}`;
        resultDiv.classList.add('error');
    }
}

function getLocalToken()
{
    if (!localStorage.getItem('token')) {
        return window.location.href = '/login';
    }
    return localStorage.getItem('token');
}
function toastMessage(toastData) {
    // console.log('siamo dentro');
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-center",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "100",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    switch (toastData['type']) {
        case 'success':
            toastr.success(toastData['message']);
            break;
        case 'warning':
            toastr.warning(toastData['message']);
            break;
        case 'info':
            toastr.info(toastData['message']);
            break;
        case 'error':
            toastr.error(toastData['message']);
            break;
    }
}

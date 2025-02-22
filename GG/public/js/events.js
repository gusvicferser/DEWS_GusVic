/**
 * JS para eventos del proyecto GG:
 *
 * Se supone que a través de un fetch, podemos mostrar los eventos que hay en la base de datos:
 */

/**
 * Función para crear un elemento y sus atributos:
 *
 * @param domElement El elemento DOM que queremos crear
 * @param domAtributes Un array con atributo:valor
 * @returns El elemento del DOM con todos los atributos
 *
 * @author Gustavo Victor
 * @version 2.1
 */
function newElement(domElement, domAtributes) {

    let dom = document.createElement(domElement);

    if (domAtributes != null || domAtributes != '') {
        domAtributes.forEach(element => {
            let atribute = element.substring(0, element.search(':'));
            let value = element.substring(element.search(':') + 1, element.length);
            dom.setAttribute(atribute, value);
        });
    }

    return dom;
}

/**
 * Función para meter todos los elementos en un elemento del DOM:
 * (REVISAR)
 *
 * @param domElement El elemento en el cual vamos a introducir los elementos
 * @param domElements Todos los elementos DOM a introducir
 *
 * @author Gustavo Víctor
 * @version 2.0
 */
function introduce(domElement, ...domElements) {

    if (domElements != null || domElements != '') {
        domElements.forEach(element => {
            domElement.appendChild(element);
        })
    }
}

fetch('/api/events').then(
    (response) => {
        if (response.ok) return response.json();
        else throw new Error(response.status);
    }).then((data) => {
        console.log(data);

        const eventContainer = document.getElementById('eventContainer');

        data.forEach(element => {

            if (element['visible'] === 1) {

                // Contenedor de cada evento:
                let dCont = newElement(
                    'div',
                    [
                        'class:' +
                        'd-flex flex-column ' +
                        'justify-content-center align-items-center ' +
                        'max-w-75 shadow-md rounded-lg p-5 mt-2 mb-4 ' +
                        'border border-success'
                    ]);

                dCont.style.backgroundColor = '#e4d4e4';

                // Nombre del evento:
                let h2Name = newElement(
                    'h2',
                    [
                        'class:' +
                        'bg-gray-100 p-4 rounded-lg mb-4'
                    ]);
                h2Name.textContent = element['name'];
                dCont.appendChild(h2Name);


                // Lugar:
                let dLoc = newElement('div', ['class:text-gray-700 text-center']);
                dLoc.textContent = element['location'];
                dCont.appendChild(dLoc);

                // Fecha:
                let date = new Date(element['date']);
                let dDate = newElement('div', ['class:text-gray-700 text-center']);

                date = date.getDate() +
                    '/' +
                    (date.getMonth() + 1) +
                    '/' +
                    date.getFullYear();
                dDate.textContent = date;
                dCont.appendChild(dDate);

                // Hora:
                let dHour = newElement('div', ['class:text-gray-700 text-center ']);
                dHour.textContent = element['hour'].substring(0, 5);
                dCont.appendChild(dHour);

                // Tipo:
                let tColor = element['type'] == 'official' ?
                    'bg-primary-500' :
                    (element['type'] == 'exhibition' ?
                        'bg-warning-500' : 'bg-success-500');
                let dType = newElement(
                    'div',
                    [
                        'class:' +
                        'py-1 rounded-full text-info text-center' +
                        tColor
                    ]
                );

                dType.textContent = element['type'].toUpperCase();
                dCont.appendChild(dType);

                // Descripción:
                let dDescCont = newElement('div', ['class:mb-2']);
                let h3Desc = newElement(
                    'h3',
                    [
                        'class:' +
                        'text-xl font-semibold text-gray-700 text-center my-4'
                    ]);

                h3Desc.textContent = 'Descripción:';
                let dDesc = newElement(
                    'div',
                    [
                        'class:text-gray-600 text-center mt-3'
                    ]);
                dDesc.textContent = element['description'];

                introduce(dDescCont, h3Desc, dDesc); // Metemos todo en el contenedor
                dCont.appendChild(dDescCont); // Y eso al contenedor general del evento

                // Tags:

                let h3Tag = newElement(
                    'h3',
                    [
                        'class:' +
                        'text-xl font-semibold text-gray-700 text-center'
                    ]);
                h3Tag.textContent = 'Tags:';
                let dTags = newElement('div', ['class:flex flex-wrap mt-2']);

                // Ahora, por cada elemento, su propio span:
                element['tags'].split(',').forEach(element => {
                    let dTag = newElement(
                        'div',
                        [
                            'class:' +
                            'bg-gray-300' +
                            'text-gray-700' +
                            'text-center' +
                            'px-3' +
                            'py-1' +
                            'rounded-full mr-2 mb-2'
                        ]);
                    dTag.textContent = '#' + element.trim();
                    dTags.appendChild(dTag);
                });

                dCont.appendChild(dTags); // Lo metemos en el Contenedor

                eventContainer.appendChild(dCont);
            }
        });
    }).catch(error => {
        console.log(error);
    })

let app = {};

document.addEventListener('DOMContentLoaded', function () {
    app =
        {
            data : {
                target : {

                    table_db_field : "#table_db_field",
                    template_db_field : "#template_db_field",
                }
            },
            actions :
                {
                    addField: function (event)
                    {
                        let fieldName = prompt('Field name');

                        let HTML = document.querySelector(app.data.target.template_db_field).innerHTML;

                        let index = document.querySelectorAll(app.data.target.table_db_field + ' tr').length;

                        HTML = HTML.replace(/\[0\]/g, `[${ index + 1 }]` );

                        console.log('innerHTML', document.querySelector(app.data.target.table_db_field).innerHTML);

                        document.querySelector(app.data.target.table_db_field).innerHTML += HTML;

                        let inputFieldName = document
                            .querySelector(app.data.target.table_db_field)
                            .querySelector('TR:last-child')
                            .querySelector('[data-db-field="name"]')
                            .querySelector('input');

                        inputFieldName.value = fieldName;

                        inputFieldName.setAttribute('value', fieldName);
                    },

                    removeField(event) {
                        //target
                        let target = event.target();

                        console.log('event', event);
                    }
                }
        };
});
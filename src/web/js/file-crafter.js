let app = {};

document.addEventListener('DOMContentLoaded', function () {
    app = {
        dbFields : {
            targets : {

                table_db_field : "#table_db_field",
                template_db_field : "#template_db_field",
            },

            getCountTR: function ()
            {
                return document.querySelectorAll(this.targets.table_db_field + ' tr').length;
            },

            getTemplateTr: function ()
            {
                return document.querySelector(this.targets.template_db_field).innerHTML;
            },

            changeIndex: function (HTML, index)
            {
                return HTML.replace(/\[0\]/g, `[${index}]`);
            },

            autocomplete : function(TR, fieldName)
            {
                //Some autocomplete
                let option = null,
                    size = null,
                    checkBox = {
                        isForeignKey : null,
                        isUnique : null
                    };


                if ( fieldName.indexOf('_id') !== -1 )
                {
                    option = 'int';
                    checkBox.isForeignKey = true;
                    size = 8;
                }

                if ( fieldName.indexOf('mail') !== -1 )
                {
                    option = 'string';
                    size = 64;
                    checkBox.isUnique = true;
                }

                if ( fieldName.indexOf('date') !== -1 ) option = 'date';
                if ( fieldName.indexOf('datetime') !== -1 ) option = 'datetime';
                if ( fieldName.indexOf('timestamp') !== -1 ) option = 'timestamp';
                if ( fieldName.indexOf('content') !== -1 ) option = 'text';
                if ( fieldName.indexOf('html') !== -1 ) option = 'text';
                if ( fieldName.indexOf('text') !== -1 ) option = 'text';
                if ( fieldName.indexOf('name') !== -1 ) option = 'string';
                if ( fieldName.indexOf('title') !== -1 ) option = 'string';

                if ( fieldName.indexOf('header') !== -1 ) {
                    option = 'string';
                    size = 80;
                }
                if ( fieldName.indexOf('title') !== -1 ) {
                    option = 'string';
                    size = 80;
                }

                if (option)
                {
                    TR.querySelector('[data-db-field="type"]')
                        .querySelector('select')
                        .querySelector(`[value="${option}"]`)
                        .setAttribute('selected', 'selected');
                }

                if (size)
                {
                    TR.querySelector('[data-db-field="size"]')
                        .querySelector('input')
                        .setAttribute('value', size);
                }

                if (checkBox.isForeignKey)
                {
                    TR.querySelector('[data-db-field="foreignKeys"]')
                        .querySelector('input')
                        .setAttribute('checked', 'checked');
                }

                if (checkBox.isUnique)
                {
                    TR.querySelector('[data-db-field="unique"]')
                        .querySelector('input')
                        .setAttribute('checked', 'checked');
                }
            },

            appendNewTR: function (HTML, fieldName)
            {
                //Кастыль! T_T
                let tbody = document.createElement('tbody');
                tbody.innerHTML = HTML;

                let TR = tbody.querySelector('TR').cloneNode(true);

                let inputFieldName = TR
                    .querySelector('[data-db-field="name"]')
                    .querySelector('input');

                inputFieldName.value = fieldName;

                inputFieldName.setAttribute('value', fieldName);

                this.autocomplete(TR, fieldName);

                document.querySelector(this.targets.table_db_field).append(TR);
            },
            addField: function ()
            {
                let fieldName = prompt('Field name'),
                    HTML = this.getTemplateTr(),
                    countTr = this.getCountTR() + 1;

                HTML = this.changeIndex(HTML, countTr);

                this.appendNewTR(HTML, fieldName);
            },

            removeField(self) {
                let TR = self.closest('TR');

                TR.remove();
            }
        },
    };
});
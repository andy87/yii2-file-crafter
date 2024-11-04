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

            changeIndex: function (HTML, fieldName)
            {
                return HTML.replace(/\[0\]/g, `[${fieldName}]`);
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
                    size = 128;
                    checkBox.isUnique = true;
                }

                if ( fieldName.indexOf('date') !== -1 ) option = 'date';

                if ( fieldName.indexOf('_at') !== -1 ) option = 'datetime';
                if ( fieldName.indexOf('datetime') !== -1 ) option = 'datetime';
                if ( fieldName.indexOf('timestamp') !== -1 ) option = 'timestamp';

                if ( fieldName.indexOf('content') !== -1 ) option = 'text';
                if ( fieldName.indexOf('html') !== -1 ) option = 'text';
                if ( fieldName.indexOf('text') !== -1 ) option = 'text';

                if ( fieldName.indexOf('name') !== -1 ) {
                    option = 'string';
                    size = 64;
                }
                if ( fieldName.indexOf('key') !== -1 ) {
                    option = 'string';
                    size = 32;
                    checkBox.isUnique = true;
                }
                if ( fieldName.indexOf('title') !== -1 ) option = 'string';
                if ( fieldName.indexOf('label') !== -1 ) option = 'string';

                if ( fieldName.indexOf('header') !== -1 ) {
                    option = 'string';
                    size = 80;
                }
                if ( fieldName.indexOf('title') !== -1 ) {
                    option = 'string';
                    size = 80;
                }
                if ( fieldName.indexOf('is') === 0 ) {
                    option = 'boolean';
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

                HTML = this.changeIndex(HTML, fieldName);

                this.appendNewTR(HTML, fieldName);
            },

            removeField(self) {
                let TR = self.closest('TR');

                TR.remove();
            },

            changeKey : function (self)
            {
                let TR = self.closest('TR');

                TR.querySelector('[data-db-field="name"]').setAttribute('data-key', self.value);
                TR.querySelector('[data-db-field="name"]').querySelector('input').setAttribute('name', `db_fields[${self.value}][name]`);
                TR.querySelector('[data-db-field="comment"]').querySelector('input').setAttribute('name', `db_fields[${self.value}][comment]`);
                TR.querySelector('[data-db-field="type"]').querySelector('select').setAttribute('name', `db_fields[${self.value}][type]`);
                TR.querySelector('[data-db-field="size"]').querySelector('input').setAttribute('name', `db_fields[${self.value}][size]`);
                TR.querySelector('[data-db-field="foreignKeys"]').querySelector('input').setAttribute('name', `db_fields[${self.value}][foreignKeys]`);
                TR.querySelector('[data-db-field="unique"]').querySelector('input').setAttribute('name', `db_fields[${self.value}][unique]`);
                TR.querySelector('[data-db-field="notNull"]').querySelector('input').setAttribute('name', `db_fields[${self.value}][notNull]`);
            }
        },

        cache : {
            removeModel: function (modelName)
            {
                let message = `Do you really want to remove the model "${modelName}"?`;

                if ( confirm(message) )
                {
                    window.location.href = `?remove=${modelName}`;
                }
            }
        }
    };
});
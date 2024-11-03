let app = {};

document.addEventListener('DOMContentLoaded', function () {
    app =
        {
            actions :
                {
                    addField: function (event)
                    {
                        let fieldName = prompt('Field name');

                        //target
                        let target = event.target();

                        console.log('event', event);
                    },

                    removeField(event) {
                        //target
                        let target = event.target();

                        console.log('event', event);
                    }
                }
        };
});
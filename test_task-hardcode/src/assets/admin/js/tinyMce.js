(function ($) {
    'use strict';
    (function () {
        tinymce.PluginManager.add('k0d_button', function (editor, url) { // id кнопки true_mce_button должен быть везде один и тот же
            editor.addButton('k0d_button', { // id кнопки true_mce_button
                text : 'Добавить шорткод k0d', // мой собственный CSS класс, благодаря которому я задам иконку кнопки
                type : 'menubutton',
                menu : [ // тут начинается первый выпадающий список
                    { // тут начинается второй выпадающий список внутри первого
                        text   : 'Настроить параметры',
                        onclick: function () {
                            editor.windowManager.open({
                                body    : [
                                    {
                                        type : 'textbox', // тип textbox = текстовое поле
                                        name : 'postType', // ID, будет использоваться ниже
                                        label: 'Тип поста', // лейбл
                                        value: 'k0d', // значение по умолчанию
                                    },
                                    {
                                        type : 'textbox', // тип textbox = текстовое поле
                                        name : 'pagen',
                                        label: 'Какую страницу выводить по умолчанию',
                                        value: 2,
                                    },
                                    {
                                        type    : 'listbox', // тип listbox = выпадающий список select
                                        name    : 'showList',
                                        label   : 'Сортровка',
                                        'values': [ // значения выпадающего списка
                                            {text: 'Сначала новые', value: 'new'}, // лейбл, значение
                                            {text: 'Сначала старые', value: 'old'}
                                        ]
                                    },
                                    {
                                        type : 'textbox', // тип listbox = выпадающий список select
                                        name : 'title',
                                        label: 'Заголовок',
                                        value: ''
                                    }
                                ],
                                onsubmit: function (e) { // это будет происходить после заполнения полей и нажатии кнопки отправки
                                    editor.insertContent(`[k0d post="${e.data.postType}" pagen="${e.data.pagen}" showlist="${e.data.showList}" title="${e.data.title}"]`);
                                }
                            });
                        }
                    }
                ]
            });
        });
    })();

})(jQuery);

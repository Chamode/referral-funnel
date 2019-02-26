(function (wp) {
    var registerPlugin = wp.plugins.registerPlugin;
    var PluginSidebar = wp.editPost.PluginSidebar;
    var el = wp.element.createElement;
    var Text = wp.components.TextControl;
    var content = "";
    var PluginSidebarMoreMenuItem = wp.editPost.PluginSidebarMoreMenuItem 

    registerPlugin('my-plugin-sidebar', {
        render: function () {
            return el(PluginSidebar,
                {
                    name: 'my-plugin-sidebar',
                    icon: 'admin-post',
                    title: 'My plugin sidebar',
                },
                el('div',
                    { className: 'plugin-sidebar-content' },
                    el(Text, {
                        label: 'Meta Block Field',
                        value: content,
                        onChange: function (input) {
                            content = content + input
                            console.log('content changed to ', input);
                        },
                    })
                )
            );
        }
    });
})(window.wp);
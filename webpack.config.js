module.exports = {
    entry: './admin/js/block.js',
    output: {
        path: __dirname,
        filename: 'admin/js/block.build.js',
    },
    module: {
        loaders: [
            {
                test: /.js$/,
                loader: 'babel-loader',
                exclude: /node_modules/,
            },
        ],
    },
};
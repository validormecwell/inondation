// esbuild.config.cjs
const esbuild = require('esbuild');

esbuild.build({
  entryPoints: ['resources/js/app.js'],
  bundle: true,
  outdir: 'public/build',
  loader: {
    '.js': 'jsx',
  },
  define: {
    'process.env.NODE_ENV': '"development"',
  },
  sourcemap: true,
}).catch(() => process.exit(1));

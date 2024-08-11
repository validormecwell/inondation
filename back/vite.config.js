// vite.config.js
import { defineConfig } from 'vite';

export default defineConfig({
  esbuild: {
    jsxFactory: 'React.createElement',
    jsxFragment: 'React.Fragment',
    loaders: {
      '.js': 'jsx', // Ajoutez cette ligne pour activer le support JSX
    },
  },
});

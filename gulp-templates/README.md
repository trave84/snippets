# Gulp by examples

Various Gulp configurations to serve as basis for your projects.

Expecting you have already installed _node.js_ and Gulp-cli `npm install -g gulp-cli` (as Administrator or with `sudo` on OSX/Linux). 

Always the same install with 

```
npm install
```

and run with 

```
gulp
```

(there may be more tasks to run, check descriptions for each config)


## 01-browserync

Browsersync automatically refreshing `.html` and `.css` files in root folder.

_This is mainly the most simple example._


## 02-scss

Same as 01 but also compiling `index.css` from Sass (scss) in `index.scss`. Generating sourcemaps too.

Also Browsersync server runs on different port.

_Again more of an example for learning._ 


## 03-advanced-css-compiling

Same as 02 but resulting CSS  

- is autoprefixed for vendor prefixes
- and some flexbox bugs are fixed 
- and minified in the end

Also for Browsersync
- server is set to try `/example.html` when `/example` is required.
- watches any html file (including those in subfolders) 

_This might be able to serve as a production ready code basis._ 


## 04-folders

Same as 03 but let's keep things more organized with folders.

`/src/static/` contains files that will be just copied as they are to the root of the website

`/src/scss/` contains all scss source files to be compiled to css

`/dist/` is created by gulp and contains the completed website and can be uploaded anywhere 

_This could be used to create a static website from scratch._

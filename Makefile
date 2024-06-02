all: styles translations zip

styles: static/admin.scss blocks/subscribe/editor.scss blocks/subscribe/style.scss
	sass static/admin.scss static/admin.css
	sass blocks/subscribe/editor.scss blocks/subscribe/editor.css
	sass blocks/subscribe/style.scss blocks/subscribe/style.css

translations: languages/mailbob.pot
	wp i18n make-pot . languages/mailbob.pot
	wp i18n update-po languages/mailbob.pot languages/
	wp i18n make-mo languages/ languages/

zip:
	rm -f ../mailbob-wp.zip
	# zip -9r mailbob-wp.zip -x Makefile -x mailbob-wp.zip -x .* .
	cd ..; zip -9r mailbob-wp.zip mailbob-wp -x "*/Makefile" -x "*/.git/*" -x "*/.gitignore" -x "*.css.map" -x "*.scss"

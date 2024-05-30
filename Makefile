all: styles translations

styles: static/admin.scss blocks/subscribe/editor.scss blocks/subscribe/style.scss
	sass static/admin.scss static/admin.css
	sass blocks/subscribe/editor.scss blocks/subscribe/editor.css
	sass blocks/subscribe/style.scss blocks/subscribe/style.css

translations: languages/mailbob.pot
	wp i18n make-pot . languages/mailbob.pot
	wp i18n update-po languages/mailbob.pot languages/
	wp i18n make-mo languages/ languages/

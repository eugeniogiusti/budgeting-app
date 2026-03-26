<?php

return [
    // Home
    'home' => 'Home',
    'ready_to_assign' => 'Da Assegnare',
    'available' => 'disponibile',
    'overspent' => 'sforato',
    'assigned' => 'assegnato',
    'assign' => 'Assegna',
    'add_income' => '+ Entrata',
    'this_month' => 'Questo mese',
    'income' => 'Entrate',
    'expenses' => 'Uscite',
    'balance' => 'Saldo',
    'top_priorities' => 'Priorità',
    'not_assigned' => 'Non assegnato',

    // Income form
    'new_income' => 'Nuova Entrata',
    'amount' => 'Importo',
    'note' => 'Nota',
    'note_placeholder' => 'Es. Stipendio, Bonus...',
    'date' => 'Data',
    'type' => 'Tipo',
    'submit_income' => 'Aggiungi Entrata',

    // Expense form
    'new_expense' => 'Nuova Spesa',
    'category' => 'Categoria',
    'select_category' => 'Seleziona categoria',
    'expense_note_placeholder' => 'Es. Supermercato, Carburante...',
    'submit_expense' => 'Aggiungi Spesa',

    // Budget
    'assign_amount' => 'Importo da assegnare',
    'save_budget' => 'Salva',
    'spent' => 'Speso',
    'no_expenses' => 'Nessuna spesa',
    'of' => 'di',

    // Goals
    'new_goal' => 'Nuovo Obiettivo',
    'goal_emoji' => 'Emoji',
    'goal_name' => 'Nome obiettivo',
    'goal_name_placeholder' => 'Es. Vacanze, Macchina...',
    'goal_target' => 'Importo obiettivo',
    'goal_date' => 'Data target',
    'optional' => 'opzionale',
    'create_goal' => 'Crea Obiettivo',
    'no_goals' => 'Nessun obiettivo',
    'no_goals_subtitle' => 'Crea il tuo primo obiettivo di risparmio',
    'goal_by' => 'Entro',
    'goal_add_funds' => '+ Fondi',
    'confirm_delete_goal' => 'Eliminare questo obiettivo?',
    'edit_goal' => 'Modifica Obiettivo',
    'save_goal' => 'Salva',

    // Stats
    'stats_by_category' => 'Spese per categoria',
    'stats_breakdown' => 'Dettaglio',
    'stats_trend' => 'Ultimi 6 mesi',
    'no_stats' => 'Nessuna spesa questo mese',
    'no_stats_subtitle' => 'Aggiungi delle spese per vedere le statistiche',

    // Transactions list
    'transactions' => 'Transazioni',
    'confirm_delete' => 'Eliminare questa spesa?',
    'confirm_delete_income' => 'Eliminare questa entrata?',
    'unknown_category' => 'Senza categoria',
    'edit_expense' => 'Modifica Spesa',
    'edit_income' => 'Modifica Entrata',
    'save_expense' => 'Salva',
    'cancel' => 'Annulla',
    'save' => 'Salva',
    'no_transactions' => 'Nessuna transazione',
    'filter_all' => 'Tutti',

    // Categories
    'categories' => 'Categorie',
    'new_category' => 'Nuova Categoria',
    'edit_category' => 'Modifica Categoria',
    'category_name' => 'Nome categoria',
    'category_name_placeholder' => 'Es. Affitto, Spesa...',
    'category_color' => 'Colore',
    'create_category' => 'Crea Categoria',
    'save_category' => 'Salva',
    'no_categories' => 'Nessuna categoria',
    'confirm_delete_category' => 'Eliminare questa categoria?',
    'category_has_data' => 'Impossibile eliminare: la categoria ha transazioni o budget associati.',
    'manage_categories' => 'Gestisci categorie',

    // Budget actions
    'copy_previous_month' => 'Copia mese precedente',
    'rollover' => 'riporto',

    // Export / Import
    'export_csv'          => 'Esporta dati (CSV)',
    'import_csv'          => 'Importa dati (CSV)',
    'import_title'        => 'Importa dati',
    'import_subtitle'     => 'Carica un file CSV esportato da questa app per ripristinare le tue transazioni. I duplicati vengono ignorati automaticamente.',
    'import_file'         => 'File CSV',
    'import_submit'           => 'Importa',
    'import_browser_only'     => 'Solo browser',
    'import_paste_label'      => 'Incolla il contenuto CSV',
    'import_paste_placeholder' => "Data,Tipo,Importo,Categoria,Nota\n2026-03-01,expense,45.00,Spesa,Supermercato\n...",
    'import_result'           => ':imported transazioni importate, :skipped ignorate.',
    'import_format_title' => 'Formato atteso',
    'import_format_desc'  => 'Il file deve avere una riga di intestazione e le colonne: Data, Tipo, Importo, Categoria, Nota.',

    // Settings
    'settings' => 'Impostazioni',
    'language' => 'Lingua',
    'currency' => 'Valuta',
    'save_settings' => 'Salva impostazioni',

    // Toast notifications
    'toast_saved'          => 'Salvato',
    'toast_deleted'        => 'Eliminato',
    'toast_copied'         => 'Copiato dal mese precedente',
    'notif_budget_exceeded_title' => 'Budget sforato',
    'notif_budget_exceeded_body'  => 'Hai superato il budget di :category di :amount',
    'toast_settings_saved' => 'Impostazioni salvate',

    // Navigation
    'nav_home' => 'Home',
    'nav_budget' => 'Budget',
    'nav_goals' => 'Obiettivi',
    'nav_stats' => 'Statistiche',
    'nav_transactions' => 'Movimenti',
    'nav_menu' => 'Menu',
    'nav_other' => 'Altro',

    // Auth
    'sign_in' => 'Accedi',
    'sign_in_subtitle' => 'Inserisci email e password per accedere.',
    'sign_up' => 'Registrati',
    'sign_up_subtitle' => 'Crea il tuo account.',
    'remember_me' => 'Ricordami',
    'no_account' => 'Non hai un account?',
    'have_account' => 'Hai già un account?',
    'name' => 'Nome',
    'name_placeholder' => 'Il tuo nome',
    'confirm_password' => 'Conferma password',
    'profile' => 'Profilo',
    'personal_info' => 'Informazioni personali',
    'change_password' => 'Cambia password',
    'current_password' => 'Password attuale',
    'new_password' => 'Nuova password',
    'profile_updated' => 'Profilo aggiornato.',
    'password_updated' => 'Password aggiornata.',
    'logout' => 'Esci',
    'app_tagline' => 'Tieni il controllo delle tue finanze.',
];

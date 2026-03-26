<?php

return [
    // Home
    'home' => 'Home',
    'ready_to_assign' => 'Ready to Assign',
    'available' => 'available',
    'overspent' => 'overspent',
    'assigned' => 'assigned',
    'assign' => 'Assign',
    'add_income' => '+ Income',
    'this_month' => 'This month',
    'income' => 'Income',
    'expenses' => 'Expenses',
    'balance' => 'Balance',
    'top_priorities' => 'Top Priorities',
    'not_assigned' => 'Not assigned',

    // Income form
    'new_income' => 'New Income',
    'amount' => 'Amount',
    'note' => 'Note',
    'note_placeholder' => 'E.g. Salary, Bonus...',
    'date' => 'Date',
    'type' => 'Type',
    'submit_income' => 'Add Income',

    // Expense form
    'new_expense' => 'New Expense',
    'category' => 'Category',
    'select_category' => 'Select category',
    'expense_note_placeholder' => 'E.g. Supermarket, Gas...',
    'submit_expense' => 'Add Expense',

    // Budget
    'assign_amount' => 'Amount to assign',
    'save_budget' => 'Save',
    'spent' => 'Spent',
    'no_expenses' => 'No expenses',
    'of' => 'of',

    // Goals
    'new_goal' => 'New Goal',
    'goal_emoji' => 'Emoji',
    'goal_name' => 'Goal name',
    'goal_name_placeholder' => 'E.g. Vacation, Car...',
    'goal_target' => 'Target amount',
    'goal_date' => 'Target date',
    'optional' => 'optional',
    'create_goal' => 'Create Goal',
    'no_goals' => 'No goals yet',
    'no_goals_subtitle' => 'Create your first savings goal',
    'goal_by' => 'By',
    'goal_add_funds' => '+ Funds',
    'confirm_delete_goal' => 'Delete this goal?',
    'edit_goal' => 'Edit Goal',
    'save_goal' => 'Save',

    // Stats
    'stats_by_category' => 'Spending by category',
    'stats_breakdown' => 'Breakdown',
    'stats_trend' => 'Last 6 months',
    'no_stats' => 'No expenses this month',
    'no_stats_subtitle' => 'Add some expenses to see statistics',

    // Transactions list
    'transactions' => 'Transactions',
    'confirm_delete' => 'Delete this expense?',
    'confirm_delete_income' => 'Delete this income?',
    'unknown_category' => 'No category',
    'edit_expense' => 'Edit Expense',
    'edit_income' => 'Edit Income',
    'save_expense' => 'Save',
    'cancel' => 'Cancel',
    'save' => 'Save',
    'no_transactions' => 'No transactions',
    'filter_all' => 'All',

    // Categories
    'categories' => 'Categories',
    'new_category' => 'New Category',
    'edit_category' => 'Edit Category',
    'category_name' => 'Category name',
    'category_name_placeholder' => 'E.g. Rent, Groceries...',
    'category_color' => 'Color',
    'create_category' => 'Create Category',
    'save_category' => 'Save',
    'no_categories' => 'No categories',
    'confirm_delete_category' => 'Delete this category?',
    'category_has_data' => 'Cannot delete: category has transactions or budgets.',
    'manage_categories' => 'Manage categories',

    // Budget actions
    'copy_previous_month' => 'Copy previous month',
    'rollover' => 'rollover',

    // Export / Import
    'export_csv'          => 'Export data (CSV)',
    'import_csv'          => 'Import data (CSV)',
    'import_title'        => 'Import data',
    'import_subtitle'     => 'Upload a CSV file exported from this app to restore your transactions. Duplicates are automatically skipped.',
    'import_file'         => 'CSV file',
    'import_submit'            => 'Import',
    'import_browser_only'      => 'Browser only',
    'import_paste_label'       => 'Paste CSV content',
    'import_paste_placeholder' => "Date,Type,Amount,Category,Note\n2026-03-01,expense,45.00,Groceries,Supermarket\n...",
    'import_result'            => ':imported transactions imported, :skipped skipped.',
    'import_format_title' => 'Expected format',
    'import_format_desc'  => 'The file must have a header row and columns: Date, Type, Amount, Category, Note.',

    // Settings
    'settings' => 'Settings',
    'language' => 'Language',
    'currency' => 'Currency',
    'save_settings' => 'Save settings',

    // Toast notifications
    'toast_saved'          => 'Saved',
    'toast_deleted'        => 'Deleted',
    'toast_copied'         => 'Copied from previous month',
    'notif_budget_exceeded_title' => 'Budget exceeded',
    'notif_budget_exceeded_body'  => 'You exceeded the :category budget by :amount',
    'toast_settings_saved' => 'Settings saved',

    // Navigation
    'nav_home' => 'Home',
    'nav_budget' => 'Budget',
    'nav_goals' => 'Goals',
    'nav_stats' => 'Stats',
    'nav_transactions' => 'Transactions',
    'nav_menu' => 'Menu',
    'nav_other' => 'Other',

    // Auth
    'sign_in' => 'Sign In',
    'sign_in_subtitle' => 'Enter your email and password to sign in.',
    'sign_up' => 'Sign Up',
    'sign_up_subtitle' => 'Create your account.',
    'remember_me' => 'Remember me',
    'no_account' => "Don't have an account?",
    'have_account' => 'Already have an account?',
    'name' => 'Name',
    'name_placeholder' => 'Your name',
    'confirm_password' => 'Confirm password',
    'profile' => 'Profile',
    'personal_info' => 'Personal information',
    'change_password' => 'Change password',
    'current_password' => 'Current password',
    'new_password' => 'New password',
    'profile_updated' => 'Profile updated.',
    'password_updated' => 'Password updated.',
    'logout' => 'Logout',
    'app_tagline' => 'Take control of your finances.',
];

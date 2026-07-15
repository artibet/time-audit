import React from 'react'
import { router, usePage } from '@inertiajs/react';
import { AccessTime, FileUploadOutlined, GroupsOutlined, PeopleAlt, SettingsSuggest } from '@mui/icons-material';

export const getSidebarMenuItems = () => {


  const { url } = usePage()
  const { auth } = usePage().props

  // ---------------------------------------------------------------------------------------
  // Αρχεία Κινήσεων
  // ---------------------------------------------------------------------------------------
  const uploadFiles = {
    label: 'Αρχεία Κινήσεων',
    icon: <FileUploadOutlined />,
    onClick: () => router.get('/upload-files'),
    active: () => url.startsWith("/upload-files"),
    hidden: () => !auth.user.has_editor_rights,
  }


  // ---------------------------------------------------------------------------------------
  // Αναφορές - section
  // ---------------------------------------------------------------------------------------
  const reportsSection = {
    label: "Αναφορές",
    section: true,
    hidden: () => !auth.user.has_editor_rights
  }

  // ---------------------------------------------------------------------------------------
  // Υπερωρίες περιόδου
  // ---------------------------------------------------------------------------------------
  const periodOvertimesMenu = {
    label: 'Υπερωρίες Περιόδου',
    icon: <AccessTime />,
    onClick: () => router.get('/reports/period-overtimes'),
    active: () => url.startsWith("/reports/period-overtimes"),
    hidden: () => !auth.user.has_editor_rights,
  }


  // ---------------------------------------------------------------------------------------
  // Διαχείριση - section
  // ---------------------------------------------------------------------------------------
  const administrationSection = {
    label: "Διαχείριση",
    section: true,
    hidden: () => !auth.user.is_superadmin
  }

  // ---------------------------------------------------------------------------------------
  // Εργαζόμενοι
  // ---------------------------------------------------------------------------------------
  const employeesMenu = {
    label: 'Εργαζόμενοι',
    icon: <GroupsOutlined />,
    onClick: () => router.get('/employees'),
    active: () => url.startsWith("/employees"),
    hidden: () => !auth.user.has_editor_rights,
  }

  // ---------------------------------------------------------------------------------------
  // Χρήστες & Ρόλοι
  // ---------------------------------------------------------------------------------------
  const usersMenu = {
    label: 'Χρήστες & Ρόλοι',
    icon: <PeopleAlt />,
    onClick: () => router.get('/users'),
    active: () => url.startsWith("/users"),
    hidden: () => !auth.user.is_superadmin,
  }

  // ---------------------------------------------------------------------------------------
  // Παράμετροι
  // ---------------------------------------------------------------------------------------
  const paramsMenu = {
    label: 'Παράμετροι',
    icon: <SettingsSuggest />,
    onClick: () => router.get('/params'),
    active: () => url.startsWith("/params"),
    hidden: () => !auth.user.has_admin_rights,
  }

  // ---------------------------------------------------------------------------------------
  // Return array of menus
  // ---------------------------------------------------------------------------------------
  return [

    uploadFiles,
    employeesMenu,

    reportsSection,
    periodOvertimesMenu,

    administrationSection,
    usersMenu,
    // paramsMenu,
  ]

}


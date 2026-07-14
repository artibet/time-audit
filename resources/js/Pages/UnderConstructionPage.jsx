import React from 'react'
import { UnderConstruction } from '@/Components/UnderConstruction'
import { AuthLayout } from '@/Layouts/AuthLayout'

const UnderConstructionPage = ({ title }) => {
  return (
    <UnderConstruction title={title} />
  )
}

// Layout and export
UnderConstructionPage.layout = page => <AuthLayout children={page} title="Under Construction" />
export default UnderConstructionPage
.. include:: ../../../../../Includes.txt


.. _ModifyTreeDataEvent:


===================
ModifyTreeDataEvent
===================

Allows to modify tree data for any database tree.

API
---


 - :Method:
         getTreeData()
   :Description:
         Returns the tree data.
   :ReturnType:
         TreeNode


 - :Method:
         setTreeData(TreeNode $treeData)
   :Description:
         Sets (overwrites) the tree data. 
   :ReturnType:
         void


 - :Method:
         getProvider()
   :Description:
         Returns the current data provider for the used tree.
   :ReturnType:
         \TYPO3\CMS\Core\Tree\TableConfiguration\AbstractTableConfigurationTreeDataProvider


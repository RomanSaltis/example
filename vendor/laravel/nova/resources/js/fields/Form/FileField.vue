<template>
  <DefaultField
    :field="currentField"
    :label-for="labelFor"
    :errors="errors"
    :full-width-content="true"
    :show-help-text="!isReadonly && showHelpText"
  >
    <template #field>
      <div v-if="hasValue" :class="{ 'mb-6': !currentlyIsReadonly }">
        <template v-if="shouldShowLoader">
          <ImageLoader
            :src="imageUrl"
            :maxWidth="maxWidth"
            :rounded="field.rounded"
            @missing="value => (missing = value)"
          />
        </template>

        <template v-if="field.value && !imageUrl">
          <card
            class="flex item-center relative border border-lg border-50 overflow-hidden p-4"
          >
            <span class="truncate mr-3"> {{ field.value }} </span>

            <DeleteButton
              :dusk="field.attribute + '-internal-delete-link'"
              class="ml-auto"
              v-if="shouldShowRemoveButton"
              @click="confirmRemoval"
            />
          </card>
        </template>

        <p
          v-if="imageUrl && !currentlyIsReadonly"
          class="mt-3 flex items-center text-sm"
        >
          <DeleteButton
            :dusk="field.attribute + '-delete-link'"
            v-if="shouldShowRemoveButton"
            @click="confirmRemoval"
          >
            <span class="class ml-2 mt-1"> {{ __('Delete') }} </span>
          </DeleteButton>
        </p>

        <ConfirmUploadRemovalModal
          :show="removeModalOpen"
          @confirm="removeFile"
          @close="closeRemoveModal"
        />
      </div>

      <p v-if="!hasValue && currentlyIsReadonly" class="pt-2 text-sm text-90">
        {{ __('This file field is read-only.') }}
      </p>

      <span
        v-if="shouldShowField"
        class="form-file mr-4"
        :class="{ 'opacity-75': currentlyIsReadonly }"
      >
        <input
          ref="fileField"
          :dusk="field.attribute"
          class="form-file-input select-none"
          type="file"
          :id="idAttr"
          name="name"
          @change="fileChange"
          :disabled="currentlyIsReadonly || uploading"
          :accept="field.acceptedTypes"
        />
        <label
          :for="labelFor"
          class="cursor-pointer focus:outline-none focus:ring rounded border-2 border-primary-300 dark:border-gray-500 hover:border-primary-500 active:border-primary-400 dark:hover:border-gray-400 dark:active:border-gray-300 bg-white dark:bg-transparent text-primary-500 dark:text-gray-400 px-3 h-9 inline-flex items-center font-bold flex-shrink-0"
        >
          <span v-if="uploading"
            >{{ __('Uploading') }} ({{ uploadProgress }}%)</span
          >
          <span v-else>{{ __('Choose File') }}</span>
        </label>
      </span>

      <span v-if="shouldShowField" class="text-90 text-sm select-none">
        {{ currentLabel }}
      </span>

      <p v-if="hasError" class="text-xs mt-2 text-red-500">{{ firstError }}</p>
    </template>
  </DefaultField>
</template>

<script>
import { Errors, DependentFormField, HandlesValidationErrors } from '@/mixins'
import Vapor from 'laravel-vapor'

export default {
  emits: ['file-upload-started', 'file-upload-finished', 'file-deleted'],

  props: [
    'resourceId',
    'relatedResourceName',
    'relatedResourceId',
    'viaRelationship',
  ],

  mixins: [HandlesValidationErrors, DependentFormField],

  data: () => ({
    file: null,
    fileName: '',
    removeModalOpen: false,
    missing: false,
    deleted: false,
    uploadErrors: new Errors(),
    vaporFile: {
      key: '',
      uuid: '',
      filename: '',
      extension: '',
    },
    uploading: false,
    uploadProgress: 0,
  }),

  mounted() {
    this.field.fill = formData => {
      let attribute = this.field.attribute

      if (this.file && !this.isVaporField) {
        formData.append(attribute, this.file, this.fileName)
      }

      if (this.file && this.isVaporField) {
        formData.append(attribute, this.fileName)
        formData.append('vaporFile[' + attribute + '][key]', this.vaporFile.key)
        formData.append(
          'vaporFile[' + attribute + '][uuid]',
          this.vaporFile.uuid
        )
        formData.append(
          'vaporFile[' + attribute + '][filename]',
          this.vaporFile.filename
        )
        formData.append(
          'vaporFile[' + attribute + '][extension]',
          this.vaporFile.extension
        )
      }
    }
  },

  methods: {
    /**
     * Respond to the file change
     */
    fileChange(event) {
      let path = event.target.value
      let fileName = path.match(/[^\\/]*$/)[0]
      this.fileName = fileName
      let extension = fileName.split('.').pop()
      this.file = this.$refs.fileField.files[0]

      if (this.isVaporField) {
        this.uploading = true
        this.$emit('file-upload-started')

        Vapor.store(this.$refs.fileField.files[0], {
          progress: progress => {
            this.uploadProgress = Math.round(progress * 100)
          },
        })
          .then(response => {
            this.vaporFile.key = response.key
            this.vaporFile.uuid = response.uuid
            this.vaporFile.filename = fileName
            this.vaporFile.extension = extension
            this.uploading = false
            this.uploadProgress = 0
            this.$emit('file-upload-finished')
          })
          .catch(error => {
            if (error.response.status === 403) {
              Nova.error(
                this.__('Sorry! You are not authorized to perform this action.')
              )
            }
          })
      }
    },

    /**
     * Confirm removal of the linked file
     */
    confirmRemoval() {
      this.removeModalOpen = true
    },

    /**
     * Close the upload removal modal
     */
    closeRemoveModal() {
      this.removeModalOpen = false
    },

    /**
     * Remove the linked file from storage
     */
    async removeFile() {
      this.uploadErrors = new Errors()

      const {
        resourceName,
        resourceId,
        relatedResourceName,
        relatedResourceId,
        viaRelationship,
      } = this
      const attribute = this.field.attribute

      const uri =
        this.viaRelationship &&
        this.relatedResourceName &&
        this.relatedResourceId
          ? `/nova-api/${resourceName}/${resourceId}/${relatedResourceName}/${relatedResourceId}/field/${attribute}?viaRelationship=${viaRelationship}`
          : `/nova-api/${resourceName}/${resourceId}/field/${attribute}`

      try {
        await Nova.request().delete(uri)
        this.closeRemoveModal()
        this.deleted = true
        this.$emit('file-deleted')
        Nova.success(this.__('The file was deleted!'))
      } catch (error) {
        this.closeRemoveModal()

        if (error.response?.status == 422) {
          this.uploadErrors = new Errors(error.response.data.errors)
        }
      }
    },
  },

  computed: {
    /**
     * Determine if the field has an upload error.
     */
    hasError() {
      return this.uploadErrors.has(this.fieldAttribute)
    },

    /**
     * Return the first error for the field.
     */
    firstError() {
      if (this.hasError) {
        return this.uploadErrors.first(this.fieldAttribute)
      }
    },

    /**
     * The current label of the file field.
     */
    currentLabel() {
      return this.fileName || this.__('no file selected')
    },

    /**
     * The ID attribute to use for the file field.
     */
    idAttr() {
      return this.labelFor
    },

    /**
     * The label attribute to use for the file field.
     */
    labelFor() {
      let name = this.resourceName

      if (this.relatedResourceName) {
        name += '-' + this.relatedResourceName
      }

      return `file-${name}-${this.field.attribute}`
    },

    /**
     * Determine whether the field has a value.
     */
    hasValue() {
      return (
        Boolean(this.field.value || this.imageUrl) &&
        !Boolean(this.deleted) &&
        !Boolean(this.missing)
      )
    },

    /**
     * Determine whether the field should show the loader component.
     */
    shouldShowLoader() {
      return !Boolean(this.deleted) && Boolean(this.imageUrl)
    },

    /**
     * Determine whether the file field input should be shown.
     */
    shouldShowField() {
      return Boolean(!this.currentlyIsReadonly)
    },

    /**
     * Determine whether the field should show the remove button.
     */
    shouldShowRemoveButton() {
      return Boolean(this.currentField.deletable && !this.currentlyIsReadonly)
    },

    /**
     * Return the preview or thumbnail URL for the field.
     */
    imageUrl() {
      return this.currentField.previewUrl || this.currentField.thumbnailUrl
    },

    /**
     * Determine the maximum width of the field.
     */
    maxWidth() {
      return this.currentField.maxWidth || 320
    },

    /**
     * Determining if the field is a Vapor field.
     */
    isVaporField() {
      return this.currentField.component == 'vapor-file-field'
    },
  },
}
</script>

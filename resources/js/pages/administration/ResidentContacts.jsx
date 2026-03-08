import React, { useState } from 'react';
import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query';
import api from '../../services/api';
import { Users, Plus, Mail, Edit, Trash2, Copy, Check } from 'lucide-react';
import SectionCard from '../../components/SectionCard';
import EmptyState from '../../components/ui/EmptyState';
import logger from '../../utils/logger';

export default function ResidentContacts() {
  const queryClient = useQueryClient();
  const [residentId, setResidentId] = useState('');
  const [showForm, setShowForm] = useState(false);
  const [editing, setEditing] = useState(null);
  const [form, setForm] = useState({ name: '', email: '', phone: '', relation: '' });
  const [inviteLink, setInviteLink] = useState(null);
  const [copied, setCopied] = useState(false);

  const { data: residentsData } = useQuery({
    queryKey: ['residents-list-contacts'],
    queryFn: async () => {
      const res = await api.get('/residents', { params: { per_page: 500, status: 'active' } });
      return res.data?.data ?? res.data ?? [];
    },
  });
  const residents = Array.isArray(residentsData) ? residentsData : residentsData?.data ?? [];

  const { data: contactsData, isLoading } = useQuery({
    queryKey: ['resident-contacts', residentId],
    queryFn: async () => {
      const res = await api.get('/resident-contacts', { params: { resident_id: residentId } });
      return res.data;
    },
    enabled: !!residentId,
  });
  const contacts = contactsData?.data ?? [];

  const createMutation = useMutation({
    mutationFn: (body) => api.post('/resident-contacts', { ...body, resident_id: Number(residentId) }),
    onSuccess: () => {
      queryClient.invalidateQueries(['resident-contacts', residentId]);
      setShowForm(false);
      setForm({ name: '', email: '', phone: '', relation: '' });
    },
    onError: (e) => {
      logger.error('Create contact failed', e);
      alert(e?.response?.data?.message || 'Failed to add contact');
    },
  });

  const updateMutation = useMutation({
    mutationFn: ({ id, ...body }) => api.put(`/resident-contacts/${id}`, body),
    onSuccess: () => {
      queryClient.invalidateQueries(['resident-contacts', residentId]);
      setEditing(null);
      setForm({ name: '', email: '', phone: '', relation: '' });
    },
    onError: (e) => {
      logger.error('Update contact failed', e);
      alert(e?.response?.data?.message || 'Failed to update');
    },
  });

  const deleteMutation = useMutation({
    mutationFn: (id) => api.delete(`/resident-contacts/${id}`),
    onSuccess: () => queryClient.invalidateQueries(['resident-contacts', residentId]),
    onError: (e) => alert(e?.response?.data?.message || 'Failed to delete'),
  });

  const handleSendInvite = async (contact) => {
    try {
      const res = await api.post(`/resident-contacts/${contact.id}/send-invite`);
      const link = res.data?.invite_link;
      if (link) {
        setInviteLink({ link, name: contact.name });
      } else {
        alert('Invite created but no link returned.');
      }
    } catch (e) {
      alert(e?.response?.data?.message || 'Failed to send invite');
    }
  };

  const copyLink = () => {
    if (inviteLink?.link) {
      navigator.clipboard.writeText(inviteLink.link);
      setCopied(true);
      setTimeout(() => setCopied(false), 2000);
    }
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    if (editing) {
      updateMutation.mutate({ id: editing.id, ...form });
    } else {
      createMutation.mutate(form);
    }
  };

  const openEdit = (c) => {
    setEditing(c);
    setForm({
      name: c.name || '',
      email: c.email || '',
      phone: c.phone || '',
      relation: c.relation || '',
    });
    setShowForm(true);
  };

  const openAdd = () => {
    setEditing(null);
    setForm({ name: '', email: '', phone: '', relation: '' });
    setShowForm(true);
  };

  return (
    <div className="max-w-4xl mx-auto">
      <div className="mb-6">
        <h1 className="text-2xl font-bold text-gray-900">Family Portal (Resident Contacts)</h1>
        <p className="text-gray-600 mt-1">
          Add family members as contacts for a resident, then send them an invite so they can log in to the Family Portal to view care updates and messages.
        </p>
      </div>

      <SectionCard className="mb-6">
        <label className="block text-sm font-medium text-gray-700 mb-2">Select resident</label>
        <select
          value={residentId}
          onChange={(e) => setResidentId(e.target.value)}
          className="w-full max-w-md border border-gray-300 rounded-lg px-3 py-2"
        >
          <option value="">Choose a resident...</option>
          {residents.map((r) => (
            <option key={r.id} value={r.id}>{r.name}</option>
          ))}
        </select>
      </SectionCard>

      {!residentId && (
        <SectionCard>
          <EmptyState
            icon={Users}
            title="Select a resident"
            description="Choose a resident above to view and manage their family contacts."
          />
        </SectionCard>
      )}

      {residentId && (
        <>
          {inviteLink && (
            <div className="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
              <p className="text-sm font-medium text-green-800 mb-2">Invite link for {inviteLink.name}</p>
              <div className="flex gap-2">
                <input
                  type="text"
                  readOnly
                  value={inviteLink.link}
                  className="flex-1 text-sm border border-green-300 rounded-lg px-3 py-2 bg-white"
                />
                <button
                  type="button"
                  onClick={copyLink}
                  className="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 flex items-center gap-2"
                >
                  {copied ? <Check className="w-4 h-4" /> : <Copy className="w-4 h-4" />}
                  {copied ? 'Copied' : 'Copy'}
                </button>
                <button
                  type="button"
                  onClick={() => setInviteLink(null)}
                  className="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50"
                >
                  Close
                </button>
              </div>
              <p className="text-xs text-green-700 mt-2">Send this link to the family member so they can sign up and access the portal.</p>
            </div>
          )}

          {showForm && (
            <SectionCard className="mb-6">
              <h2 className="text-lg font-semibold text-gray-900 mb-4">{editing ? 'Edit contact' : 'Add contact'}</h2>
              <form onSubmit={handleSubmit} className="space-y-4">
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">Name</label>
                  <input
                    type="text"
                    required
                    value={form.name}
                    onChange={(e) => setForm((f) => ({ ...f, name: e.target.value }))}
                    className="w-full border border-gray-300 rounded-lg px-3 py-2"
                  />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">Email (needed for invite)</label>
                  <input
                    type="email"
                    value={form.email}
                    onChange={(e) => setForm((f) => ({ ...f, email: e.target.value }))}
                    className="w-full border border-gray-300 rounded-lg px-3 py-2"
                  />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                  <input
                    type="text"
                    value={form.phone}
                    onChange={(e) => setForm((f) => ({ ...f, phone: e.target.value }))}
                    className="w-full border border-gray-300 rounded-lg px-3 py-2"
                  />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-1">Relation (e.g. spouse, child)</label>
                  <input
                    type="text"
                    value={form.relation}
                    onChange={(e) => setForm((f) => ({ ...f, relation: e.target.value }))}
                    className="w-full border border-gray-300 rounded-lg px-3 py-2"
                  />
                </div>
                <div className="flex gap-2">
                  <button type="submit" className="px-4 py-2 bg-[var(--theme-primary)] text-[var(--theme-text-on-primary)] rounded-lg hover:opacity-90">
                    {editing ? 'Update' : 'Add contact'}
                  </button>
                  <button type="button" onClick={() => { setShowForm(false); setEditing(null); }} className="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Cancel
                  </button>
                </div>
              </form>
            </SectionCard>
          )}

          <SectionCard>
            <div className="flex items-center justify-between mb-4">
              <h2 className="text-lg font-semibold text-gray-900">Contacts</h2>
              {!showForm && (
                <button type="button" onClick={openAdd} className="inline-flex items-center gap-2 px-4 py-2 bg-[var(--theme-primary)] text-[var(--theme-text-on-primary)] rounded-lg hover:opacity-90">
                  <Plus className="w-4 h-4" />
                  Add contact
                </button>
              )}
            </div>
            {isLoading ? (
              <p className="text-gray-500">Loading...</p>
            ) : contacts.length === 0 ? (
              <EmptyState icon={Users} title="No contacts" description="Add a family member as a contact, then send them an invite to access the Family Portal." />
            ) : (
              <ul className="space-y-3">
                {contacts.map((c) => (
                  <li key={c.id} className="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                    <div>
                      <p className="font-medium text-gray-900">{c.name}</p>
                      <p className="text-sm text-gray-500">{c.email || 'No email'}{c.relation ? ` · ${c.relation}` : ''}</p>
                      {c.user_id && <span className="text-xs text-green-600">Portal access linked</span>}
                    </div>
                    <div className="flex items-center gap-2">
                      {c.email && (
                        <button
                          type="button"
                          onClick={() => handleSendInvite(c)}
                          className="p-2 text-gray-600 hover:bg-gray-100 rounded-lg"
                          title="Send portal invite"
                        >
                          <Mail className="w-4 h-4" />
                        </button>
                      )}
                      <button type="button" onClick={() => openEdit(c)} className="p-2 text-gray-600 hover:bg-gray-100 rounded-lg" title="Edit">
                        <Edit className="w-4 h-4" />
                      </button>
                      <button
                        type="button"
                        onClick={() => window.confirm('Remove this contact?') && deleteMutation.mutate(c.id)}
                        className="p-2 text-red-600 hover:bg-red-50 rounded-lg"
                        title="Delete"
                      >
                        <Trash2 className="w-4 h-4" />
                      </button>
                    </div>
                  </li>
                ))}
              </ul>
            )}
          </SectionCard>
        </>
      )}
    </div>
  );
}
